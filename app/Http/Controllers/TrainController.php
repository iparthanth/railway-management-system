<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Train;
use App\Models\Route as TrainRoute;
use App\Models\Station;
use App\Models\Coach;
use App\Models\Booking;
use App\Models\BookingSeat;

class TrainController extends Controller
{
    /**
     * List trains with a representative active route (if any) for display.
     */
    public function index()
    {
        // Load trains with an active route (pick the first active route per train if exists)
        $trains = Train::query()
            ->with(['routes' => function ($q) {
                $q->where('is_active', true)
                  ->with(['fromStation', 'toStation'])
                  ->orderBy('id');
            }])
            ->get()
            ->map(function (Train $train) {
                $route = $train->routes->first();
                return [
                    'id' => $train->id,
                    'name' => $train->name,
                    'number' => $train->number,
                    'from' => $route?->fromStation?->name ?? '-',
                    'to' => $route?->toStation?->name ?? '-',
                    'departure' => $route?->departure_time?->format('H:i') ?? '--:--',
                    'arrival' => $route?->arrival_time?->format('H:i') ?? '--:--',
                    'duration' => $route ? sprintf('%dh %02dm', intdiv($route->duration_minutes, 60), $route->duration_minutes % 60) : '-',
                    'distance' => $route ? ($route->distance_km . ' km') : '-',
                ];
            })
            ->all();

        return view('trains.index', compact('trains'));
    }

    /**
     * Search trains by from/to station names and show matching routes for a given date.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'from_station' => 'required|string',
            'to_station' => 'required|string|different:from_station',
            'journey_date' => 'required|date',
            'passengers' => 'required|integer|min:1|max:4',
        ]);

        // Resolve station names to IDs
        $from = Station::where('name', $validated['from_station'])->first();
        $to = Station::where('name', $validated['to_station'])->first();
        if (!$from || !$to) {
            return back()->withErrors(['stations' => 'Invalid stations selected.'])->withInput();
        }

        // Find active routes matching from/to
        $routes = TrainRoute::with(['train'])
            ->where('from_station_id', $from->id)
            ->where('to_station_id', $to->id)
            ->where('is_active', true)
            ->get();

        $journeyDate = Carbon::parse($validated['journey_date'])->toDateString();

        $results = $routes->map(function (TrainRoute $route) use ($journeyDate) {
            // Price directly from route base_price
            $price = (float) $route->base_price;

            // Compute availability: total seats of train minus booked seats for date
            $totalSeats = Coach::where('train_id', $route->train_id)->sum('total_seats');
            $bookedCount = BookingSeat::query()
                ->whereHas('booking', function ($q) use ($route, $journeyDate) {
                    $q->where('train_id', $route->train_id)
                      ->where('route_id', $route->id)
                      ->whereDate('journey_date', $journeyDate)
                      ->whereIn('booking_status', ['confirmed', 'pending']);
                })
                ->count();
            $available = max(0, (int)$totalSeats - (int)$bookedCount);

            return [
                'id' => $route->train->id,
                'name' => $route->train->name,
                'number' => $route->train->number,
                'from' => $route->fromStation?->name ?? '-',
                'to' => $route->toStation?->name ?? '-',
                'departure' => $route->departure_time?->format('H:i') ?? '--:--',
                'arrival' => $route->arrival_time?->format('H:i') ?? '--:--',
                'duration' => sprintf('%dh %02dm', intdiv($route->duration_minutes, 60), $route->duration_minutes % 60),
                'distance' => ($route->distance_km . ' km'),
                'price' => $price,
                'available_seats' => $available,
                // Pass route_id forward so seats page can lock to this route
                'route_id' => $route->id,
            ];
        })->values()->all();

        return view('trains.search-results', [
            'trains' => $results,
            'searchParams' => $validated,
        ]);
    }

    /**
     * Seats page for a specific train (optionally tied to a route).
     * Keeps the 7-day window UI; availability generation can later be swapped to DB.
     */
    public function seats($trainId)
    {
        $train = Train::find((int)$trainId);
        if (!$train) {
            abort(404, 'Train not found');
        }

        // If a route is provided, use it to show from/to; else pick first active
        $routeId = request('route_id');
        $route = null;
        if ($routeId) {
            $route = TrainRoute::with(['fromStation', 'toStation'])->where('train_id', $train->id)->find($routeId);
        }
        if (!$route) {
            $route = TrainRoute::with(['fromStation', 'toStation'])
                ->where('train_id', $train->id)
                ->where('is_active', true)
                ->orderBy('id')
                ->first();
        }

        // Base seat list for a single coach (4x4) to match current view grid
        $allSeats = ['A1','A2','A3','A4','B1','B2','B3','B4','C1','C2','C3','C4','D1','D2','D3','D4'];

        // Determine start (rolling forward) and selected dates
        $today = Carbon::today();
        $requestedStart = request('journey_date') ? Carbon::parse(request('journey_date')) : $today;
        $startDate = $requestedStart->lt($today) ? $today : $requestedStart;

        $selectedDate = request('date') ?: $startDate->toDateString();
        $selected = Carbon::parse($selectedDate);

        // Build a 7-day rolling window starting at startDate
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $bookedForDay = $this->generateBookedSeatsForDate($date, $allSeats, $train->number);
            $week[] = [
                'date' => $date->toDateString(),
                'label' => $date->format('D d M'),
                'booked_count' => count($bookedForDay),
                'is_full' => count($bookedForDay) === count($allSeats),
                'available' => count($allSeats) - count($bookedForDay),
            ];
        }

        // Clamp selectedDate to the rolling window
        if ($selected->lt($startDate) || $selected->gt($startDate->copy()->addDays(6))) {
            $selected = $startDate->copy();
            $selectedDate = $selected->toDateString();
        }

        $bookedSeats = $this->generateBookedSeatsForDate($selected, $allSeats, $train->number);
        $isFullyBooked = count($bookedSeats) === count($allSeats);

        $trainData = [
            'id' => $train->id,
            'name' => $train->name,
            'number' => $train->number,
            'from' => $route?->fromStation?->name ?? '-',
            'to' => $route?->toStation?->name ?? '-',
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

    /**
     * Simple demo: choose booked seats by weekday so it's easy to read and grade.
     * Wed is fully booked. Other days vary between light/medium/high.
     * NOTE: You can replace this with DB-driven availability later.
     */
    private function generateBookedSeatsForDate(Carbon $date, array $allSeats, string $trainNumber): array
    {
        $day = (int) $date->dayOfWeekIso; // 1=Mon ... 7=Sun

        $light = ['A1','B3','C1'];
        $medium = ['A1','A2','B2','C3','D1','D3'];
        $high = ['A1','A2','A3','B1','B2','C2','C3','D2','D3','B4','C1','A4','D1'];
        $almostFull = ['A1','A2','A3','A4','B1','B2','B3','C1','C2','C3','D1','D2','D3','B4','C4'];

        switch ($day) {
            case 3: // Wed - fully booked
                return $allSeats;
            case 1: // Mon - light
                return $light;
            case 2: // Tue - medium
                return $medium;
            case 4: // Thu - medium/high
                return $high;
            case 5: // Fri - almost full
                return $almostFull;
            case 6: // Sat - light
                return $light;
            case 7: // Sun - medium
            default:
                return $medium;
        }
    }
}
