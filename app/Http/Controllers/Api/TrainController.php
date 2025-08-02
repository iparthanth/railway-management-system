<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index()
    {
        $trains = Train::with(['routes.station'])->active()->get();
        return response()->json($trains);
    }

    public function show(Train $train)
    {
        $train->load(['routes.station', 'trainClasses']);
        return response()->json($train);
    }

    public function search(Request $request)
    {
        $request->validate([
            'from_station' => 'required|exists:stations,id',
            'to_station' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
        ]);

        // This would contain the same logic as HomeController::searchTrains
        // For now, return empty array
        return response()->json([]);
    }
}
