<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Train;
use App\Models\Route as TrainRoute;
use App\Models\Station;
use App\Models\Coach;
use App\Models\BookingSeat;

class TrainController extends Controller
{
    // Show all trains with a sample active route (if exists)
    public function index()
    {
        // Load trains and their active routes (first one only for simple display)
        $trainModels = Train::with(['routes' => function ($q) {
            $q->where('is_active', true)->with(['fromStation', 'toStation'])->orderBy('id');
        }])->get();

        $trains = [];
        foreach ($trainModels as $t) {
            $route = $t->routes->first();

            $fromName = $route && $route->fromStation ? $route->fromStation->name : '-';
            $toName = $route && $route->toStation ? $route->toStation->name : '-';
            $departure = $route && $route->departure_time ? $route->departure_time->format('H:i') : '--:--';
            $arrival = $route && $route->arrival_time ? $route->arrival_time->format('H:i') : '--:--';
            $duration = $route ? sprintf('%dh %02dm', intdiv($route->duration_minutes, 60), $route->duration_minutes % 60) : '-';
            $distance = $route ? ($route->distance_km . ' km') : '-';

            $trains[] = [
                'id' => $t->id,
                'name' => $t->name,
                'number' => $t->number,
                'from' => $fromName,
                'to' => $toName,
                'departure' => $departure,
                'arrival' => $arrival,
                'duration' => $duration,
                'distance' => $distance,
            ];
        }

        return view('trains.index', compact('trains'));
    }

    // Search trains by station names. Keeps same behavior as before.
    public function search(Request $request)
    {
        $data = $request->validate([
            'from_station' => 'required|string',
            'to_station' => 'required|string|different:from_station',
            'journey_date' => 'required|date',
            'passengers' => 'required|integer|min:1|max:4',
        ]);

        // Turn station names into IDs
        $from = Station::where('name', $data['from_station'])->first();
        $to = Station::where('name', $data['to_station'])->first();
        if (!$from || !$to) {
            return back()->withErrors(['stations' => 'Please select valid stations.'])->withInput();
        }

        // Find active routes that match from->to
        $routes = TrainRoute::with('train')
            ->where('from_station_id', $from->id)
            ->where('to_station_id', $to->id)
            ->where('is_active', true)
            ->get();

        $journeyDate = Carbon::parse($data['journey_date'])->toDateString();

        $results = [];
        foreach ($routes as $route) {
            // Price is from route's base_price
            $price = (float) $route->base_price;

            // Available seats = coach total minus booked seats for that date and route
            $totalSeats = Coach::where('train_id', $route->train_id)->sum('total_seats');

            $bookedCount = BookingSeat::whereHas('booking', function ($q) use ($route, $journeyDate) {
                $q->where('train_id', $route->train_id)
                  ->where('route_id', $route->id)
                  ->whereDate('journey_date', $journeyDate)
                  ->whereIn('booking_status', ['confirmed', 'pending']);
            })->count();

            $available = $totalSeats - $bookedCount;
            if ($available < 0) { $available = 0; }

            $results[] = [
                'id' => $route->train->id,
                'name' => $route->train->name,
                'number' => $route->train->number,
                'from' => $from->name,
                'to' => $to->name,
                'departure' => $route->departure_time ? $route->departure_time->format('H:i') : '--:--',
                'arrival' => $route->arrival_time ? $route->arrival_time->format('H:i') : '--:--',
                'duration' => sprintf('%dh %02dm', intdiv($route->duration_minutes, 60), $route->duration_minutes % 60),
                'distance' => $route->distance_km . ' km',
                'price' => $price,
                'available_seats' => $available,
                'route_id' => $route->id,
            ];
        }

        return view('trains.search-results', [
            'trains' => $results,
            'searchParams' => $data,
        ]);
    }

    // Seats page (keeps the same UI/logic as before so nothing changes visually)
    public function seats($trainId)
    {
        $train = Train::find((int) $trainId);
        if (!$train) {
            abort(404, 'Train not found');
        }

        // If route_id is given, use it to fill from/to; else use first active route
        $route = null;
        $routeId = request('route_id');
        if ($routeId) {
            $route = TrainRoute::with(['fromStation', 'toStation'])
                ->where('train_id', $train->id)
                ->find($routeId);
        }
        if (!$route) {
            $route = TrainRoute::with(['fromStation', 'toStation'])
                ->where('train_id', $train->id)
                ->where('is_active', true)
                ->orderBy('id')
                ->first();
        }

        // This list matches the current seat grid (4x4)
        $allSeats = ['A1','A2','A3','A4','B1','B2','B3','B4','C1','C2','C3','C4','D1','D2','D3','D4'];

        // Start date is the later of today or requested journey_date
        $today = Carbon::today();
        $requested = request('journey_date') ? Carbon::parse(request('journey_date')) : $today;
        $startDate = $requested->lt($today) ? $today : $requested;

        // Selected date defaults to startDate
        $selectedDate = request('date');
        if (!$selectedDate) {
            $selectedDate = $startDate->toDateString();
        }
        $selected = Carbon::parse($selectedDate);

        // Build 7-day strip
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $d = $startDate->copy()->addDays($i);
            $bookedForDay = $this->demoBookedSeats($d, $allSeats);
            $week[] = [
                'date' => $d->toDateString(),
                'label' => $d->format('D d M'),
                'booked_count' => count($bookedForDay),
                'is_full' => count($bookedForDay) === count($allSeats),
                'available' => count($allSeats) - count($bookedForDay),
            ];
        }

        // Keep selected inside 7-day window
        if ($selected->lt($startDate) || $selected->gt($startDate->copy()->addDays(6))) {
            $selected = $startDate->copy();
            $selectedDate = $selected->toDateString();
        }

        $bookedSeats = $this->demoBookedSeats($selected, $allSeats);
        $isFullyBooked = count($bookedSeats) === count($allSeats);

        $trainData = [
            'id' => $train->id,
            'name' => $train->name,
            'number' => $train->number,
            'from' => $route && $route->fromStation ? $route->fromStation->name : '-',
            'to' => $route && $route->toStation ? $route->toStation->name : '-',
            'total_seats' => count($allSeats),
            'available_seats' => count($allSeats) - count($bookedSeats),
            'journey_date' => $startDate->toDateString(),
        ];

        return view('trains.seats', [
            'train' => $trainData,
            'week' => $week,
            'selectedDate' => $selectedDate,
            'bookedSeats' => $bookedSeats,
            'isFullyBooked' => $isFullyBooked,
        ]);
    }

    // Simple, readable demo of booked seats depending on weekday
    private function demoBookedSeats(Carbon $date, array $allSeats): array
    {
        $day = (int) $date->dayOfWeekIso; // 1..7

        $light = ['A1','B3','C1'];
        $medium = ['A1','A2','B2','C3','D1','D3'];
        $high = ['A1','A2','A3','B1','B2','C2','C3','D2','D3','B4','C1','A4','D1'];
        $almostFull = ['A1','A2','A3','A4','B1','B2','B3','C1','C2','C3','D1','D2','D3','B4','C4'];

        if ($day === 3) return $allSeats;         // Wed - full
        if ($day === 1) return $light;            // Mon
        if ($day === 2) return $medium;           // Tue
        if ($day === 4) return $high;             // Thu
        if ($day === 5) return $almostFull;       // Fri
        if ($day === 6) return $light;            // Sat
        return $medium;                            // Sun
    }

    // Show passenger form after seats selected
    public function passengerForm($trainId, Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'seats' => 'required|array|min:1',
            'seats.*' => 'string',
            'passengers' => 'nullable|integer|min:1|max:4',
            'route_id' => 'nullable|integer',
        ]);

        $train = Train::findOrFail((int)$trainId);
        $route = null;
        if (!empty($validated['route_id'])) {
            $route = TrainRoute::with(['fromStation','toStation'])->where('train_id', $train->id)->find($validated['route_id']);
        }

        // number of passenger rows = number of seats selected (or provided passengers, whichever is smaller)
        $count = count($validated['seats']);
        if (!empty($validated['passengers'])) {
            $count = min($count, (int)$validated['passengers']);
        }

        return view('trains.passengers', [
            'train' => $train,
            'route' => $route,
            'journey_date' => Carbon::parse($validated['date'])->toDateString(),
            'selected_seats' => $validated['seats'],
            'passenger_count' => $count,
        ]);
    }

    // Store booking with passenger info and total into DB
    public function storeBooking($trainId, Request $request)
    {
        $data = $request->validate([
            'journey_date' => 'required|date',
            'route_id' => 'nullable|integer',
            'seats' => 'required|array|min:1',
            'seats.*' => 'string',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string',
            'passengers.*.type' => 'required|in:adult,child',
        ]);

        $train = Train::findOrFail((int)$trainId);
        $route = null;
        if (!empty($data['route_id'])) {
            $route = TrainRoute::where('train_id', $train->id)->find($data['route_id']);
        } else {
            $route = TrainRoute::where('train_id', $train->id)->where('is_active', true)->first();
        }

        // Pricing
        $base = $route ? (float)$route->base_price : 0.0;
        $total = 0.0;
        foreach ($data['passengers'] as $p) {
            $total += $p['type'] === 'child' ? ($base * 0.5) : $base;
        }

        // Create booking
        $booking = \App\Models\Booking::create([
            'booking_reference' => 'BR-' . strtoupper(str()->random(6)),
            'train_id' => $train->id,
            'route_id' => $route?->id,
            'coach_id' => null,
            'journey_date' => Carbon::parse($data['journey_date'])->toDateString(),
            'passenger_name' => $data['passengers'][0]['name'], // store primary contact
            'passenger_email' => null,
            'passenger_phone' => null,
            'passenger_count' => count($data['passengers']),
            'total_amount' => $total,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Attach booking seats (we don’t have seat IDs from DB here; we only have labels like A1, A2)
        // If your Seat table maps seat_number to seat IDs, we will attempt to resolve them.
        $seatModels = \App\Models\Seat::whereIn('seat_number', $data['seats'])->get()->keyBy('seat_number');

        foreach ($data['passengers'] as $i => $p) {
            $label = $data['seats'][$i] ?? null;
            $seatId = $label && isset($seatModels[$label]) ? $seatModels[$label]->id : null;

            \App\Models\BookingSeat::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId,
                'passenger_name' => $p['name'],
                'passenger_age' => null,
                'passenger_gender' => null,
            ]);
        }

        return redirect()->route('payment.create', ['booking' => $booking->id])
            ->with('success', 'Booking created. Proceed to payment.');
    }
}
