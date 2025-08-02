<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Station;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function information()
    {
        $trains = Train::where('is_active', true)->orderBy('name')->get();
        return view('train-information', compact('trains'));
    }

    public function getTrainDetails(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
        ]);

        $train = Train::with(['routes.station'])->find($request->train_id);
        
        return response()->json([
            'train' => $train,
            'routes' => $train->routes->map(function($route) {
                return [
                    'station' => $route->station->name,
                    'arrival' => $route->arrival_time ? $route->arrival_time->format('H:i') : null,
                    'departure' => $route->departure_time->format('H:i'),
                    'halt' => $route->halt_duration . 'min',
                    'distance' => $route->distance_from_origin . 'km',
                ];
            })
        ]);
    }

    public function searchByName(Request $request)
    {
        $search = $request->get('q', '');
        
        $trains = Train::where('is_active', true)
            ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('number', 'LIKE', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'number']);

        return response()->json($trains);
    }
}
