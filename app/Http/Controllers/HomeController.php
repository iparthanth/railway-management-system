<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Train;
use App\Models\TrainClass;
use App\Models\Route;
use App\Models\Seat;
use App\Models\ActiveUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Track active users
        $this->trackActiveUser(request());
        
        $stations = Station::active()->orderBy('name')->get();
        $classes = ['AC_B', 'AC_S', 'SNIGDHA', 'F_BERTH', 'F_SEAT', 'F_CHAIR', 'S_CHAIR', 'SHOVAN', 'SHULOV', 'AC_CHAIR'];
        
        return view('home', compact('stations', 'classes'));
    }

    public function searchTrains(Request $request)
    {
        $request->validate([
            'from_station' => 'required|exists:stations,id',
            'to_station' => 'required|exists:stations,id|different:from_station',
            'journey_date' => 'required|date|after_or_equal:today',
            'class' => 'nullable|string',
        ]);

        $fromStation = Station::find($request->from_station);
        $toStation = Station::find($request->to_station);
        $journeyDate = Carbon::parse($request->journey_date);
        $dayOfWeek = strtolower($journeyDate->format('D'));

        // Track search activity
        $this->trackActiveUser($request, [
            'from_station' => $fromStation->name,
            'to_station' => $toStation->name,
            'journey_date' => $journeyDate->format('Y-m-d'),
        ]);

        // Find trains that run on this day and have routes through both stations
        $trains = Train::active()
            ->whereJsonContains('running_days', $dayOfWeek)
            ->whereHas('routes', function($query) use ($request) {
                $query->where('station_id', $request->from_station);
            })
            ->whereHas('routes', function($query) use ($request) {
                $query->where('station_id', $request->to_station);
            })
            ->with(['routes.station', 'trainClasses', 'seats'])
            ->get();

        // Filter trains where from_station comes before to_station in the route
        $availableTrains = $trains->filter(function($train) use ($request) {
            $fromSequence = $train->routes->where('station_id', $request->from_station)->first()?->sequence;
            $toSequence = $train->routes->where('station_id', $request->to_station)->first()?->sequence;
            
            return $fromSequence && $toSequence && $fromSequence < $toSequence;
        });

        // Calculate availability and active users for each train class
        foreach ($availableTrains as $train) {
            foreach ($train->trainClasses as $trainClass) {
                $availableSeats = $train->seats
                    ->where('class_name', $trainClass->class_name)
                    ->filter(function($seat) use ($request) {
                        return $seat->isAvailableForDate($request->journey_date);
                    })
                    ->count();
                
                $trainClass->available_seats = $availableSeats;
                $trainClass->active_users = rand(5, 25); // Simulate active users
            }
        }

        // Get total active users for this search
        $activeUsersCount = $this->getActiveUsersCount();

        return view('search-results', compact(
            'availableTrains', 
            'fromStation', 
            'toStation', 
            'journeyDate',
            'activeUsersCount',
            'request'
        ));
    }

    public function getStations(Request $request)
    {
        $search = $request->get('q', '');
        
        $stations = Station::active()
            ->where('name', 'LIKE', "%{$search}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($stations);
    }

    private function trackActiveUser(Request $request, $searchParams = null)
    {
        ActiveUser::updateOrCreate(
            ['session_id' => session()->getId()],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'current_page' => $request->path(),
                'search_params' => $searchParams,
                'last_activity' => now(),
            ]
        );

        // Clean up old active users (older than 5 minutes)
        ActiveUser::where('last_activity', '<', now()->subMinutes(5))->delete();
    }

    private function getActiveUsersCount()
    {
        return ActiveUser::where('last_activity', '>', now()->subMinutes(5))->count();
    }
}
