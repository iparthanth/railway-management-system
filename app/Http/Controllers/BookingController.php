<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Train;
use App\Models\Station;
use App\Models\TrainClass;
use App\Models\Seat;
use App\Models\SeatLock;
use App\Models\Payment;
use App\Services\SmsService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $smsService;
    protected $paymentService;

    public function __construct(SmsService $smsService, PaymentService $paymentService)
    {
        $this->middleware('auth');
        $this->smsService = $smsService;
        $this->paymentService = $paymentService;
    }

    public function selectSeats(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
            'class_name' => 'required|string',
        ]);

        $train = Train::with(['routes.station', 'trainClasses'])->find($request->train_id);
        $fromStation = Station::find($request->from_station_id);
        $toStation = Station::find($request->to_station_id);
        $trainClass = $train->trainClasses->where('class_name', $request->class_name)->first();

        if (!$trainClass) {
            return back()->withErrors(['class_name' => 'Selected class not available for this train.']);
        }

        // Get available seats for this class
        $availableSeats = $train->seats
            ->where('class_name', $request->class_name)
            ->filter(function($seat) use ($request) {
                return $seat->isAvailableForDate($request->journey_date, session()->getId());
            });

        if ($availableSeats->isEmpty()) {
            return back()->withErrors(['availability' => 'No seats available for selected class.']);
        }

        return view('booking.select-seats', compact(
            'train', 'fromStation', 'toStation', 'trainClass', 'availableSeats', 'request'
        ));
    }

    public function confirmSeats(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
            'class_name' => 'required|string',
            'selected_seats' => 'required|array|min:1',
            'selected_seats.*' => 'exists:seats,id',
            'boarding_station' => 'required|string',
        ]);

        // Verify seats are still available
        $seats = Seat::whereIn('id', $request->selected_seats)->get();
        foreach ($seats as $seat) {
            if (!$seat->isAvailableForDate($request->journey_date, session()->getId())) {
                return back()->withErrors(['seats' => 'One or more selected seats are no longer available.']);
            }
        }

        // Lock the seats
        SeatLock::lockSeats(
            $request->selected_seats,
            Auth::id(),
            $request->journey_date,
            session()->getId(),
            15 // 15 minutes lock
        );

        $train = Train::with(['trainClasses'])->find($request->train_id);
        $fromStation = Station::find($request->from_station_id);
        $toStation = Station::find($request->to_station_id);
        $trainClass = $train->trainClasses->where('class_name', $request->class_name)->first();

        // Calculate fare
        $ticketFare = $trainClass->base_fare * count($request->selected_seats);
        $vat = $ticketFare * 0.15; // 15% VAT
        $serviceCharge = 50; // Fixed service charge
        $totalAmount = $ticketFare + $vat + $serviceCharge;

        return view('booking.confirm-seats', compact(
            'train', 'fromStation', 'toStation', 'trainClass', 'seats',
            'ticketFare', 'vat', 'serviceCharge', 'totalAmount', 'request'
        ));
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
            'class_name' => 'required|string',
            'selected_seats' => 'required|array|min:1',
            'boarding_station' => 'required|string',
        ]);

        $user = Auth::user();
        $otp = $user->generateOtp();
        
        // Send OTP via SMS
        $this->smsService->sendOtp($user->mobile, $otp);

        // Store booking data in session
        session(['booking_data' => $request->all()]);

        return view('booking.verify-otp', compact('user'));
    }

    public function verifyBookingOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:4',
        ]);

        $user = Auth::user();
        
        if (!$user->verifyOtp($request->otp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->withErrors(['error' => 'Booking session expired.']);
        }

        return view('booking.passenger-details', compact('bookingData'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.type' => 'required|in:adult,child',
            'contact_mobile' => 'required|string',
            'contact_email' => 'required|email',
        ]);

        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->withErrors(['error' => 'Booking session expired.']);
        }

        DB::beginTransaction();
        try {
            // Verify seats are still locked by this user
            $seatLocks = SeatLock::whereIn('seat_id', $bookingData['selected_seats'])
                ->where('journey_date', $bookingData['journey_date'])
                ->where('session_id', session()->getId())
                ->where('locked_until', '>', now())
                ->get();

            if ($seatLocks->count() !== count($bookingData['selected_seats'])) {
                throw new \Exception('Seat reservation expired. Please try again.');
            }

            $train = Train::with('trainClasses')->find($bookingData['train_id']);
            $trainClass = $train->trainClasses->where('class_name', $bookingData['class_name'])->first();

            // Calculate fare
            $ticketFare = $trainClass->base_fare * count($bookingData['selected_seats']);
            $vat = $ticketFare * 0.15;
            $serviceCharge = 50;
            $totalAmount = $ticketFare + $vat + $serviceCharge;

            // Create booking
            $booking = Booking::create([
                'pnr' => Booking::generatePNR(),
                'user_id' => Auth::id(),
                'train_id' => $bookingData['train_id'],
                'from_station_id' => $bookingData['from_station_id'],
                'to_station_id' => $bookingData['to_station_id'],
                'journey_date' => $bookingData['journey_date'],
                'class_name' => $bookingData['class_name'],
                'selected_seats' => $bookingData['selected_seats'],
                'passengers' => $request->passengers,
                'contact_mobile' => $request->contact_mobile,
                'contact_email' => $request->contact_email,
                'ticket_fare' => $ticketFare,
                'vat' => $vat,
                'service_charge' => $serviceCharge,
                'total_amount' => $totalAmount,
                'boarding_station' => $bookingData['boarding_station'],
                'booking_expires_at' => now()->addMinutes(15),
                'status' => 'pending',
            ]);

            DB::commit();
            
            // Clear booking data from session
            session()->forget('booking_data');

            return redirect()->route('booking.payment', $booking->id);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->isExpired()) {
            $booking->update(['status' => 'expired']);
            return redirect()->route('booking.expired', $booking->id);
        }

        return view('booking.payment', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|in:bkash,nagad,rocket,upay,visa,mastercard',
        ]);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->isExpired()) {
            $booking->update(['status' => 'expired']);
            return redirect()->route('booking.expired', $booking->id);
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'transaction_id' => Payment::generateTransactionId(),
            'payment_method' => $request->payment_method,
            'amount' => $booking->total_amount,
            'status' => 'pending',
        ]);

        // Redirect to payment gateway
        return $this->paymentService->initiatePayment($payment);
    }

    public function paymentCallback(Request $request, Payment $payment)
    {
        $result = $this->paymentService->handleCallback($request, $payment);
        
        if ($result['success']) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_response' => $result['data'],
                'gateway_transaction_id' => $result['data']['transaction_id'] ?? null,
            ]);

            $payment->booking->update(['status' => 'confirmed']);

            // Release seat locks
            SeatLock::whereIn('seat_id', $payment->booking->selected_seats)
                ->where('journey_date', $payment->booking->journey_date)
                ->delete();

            return redirect()->route('booking.success', $payment->booking->id);
        } else {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $result['message'],
                'gateway_response' => $result['data'],
            ]);

            return redirect()->route('booking.failed', $payment->booking->id);
        }
    }

    public function success(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking.success', compact('booking'));
    }

    public function failed(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking.failed', compact('booking'));
    }

    public function expired(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking.expired', compact('booking'));
    }
}
