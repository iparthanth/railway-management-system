<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainController extends Controller
{
    private function getTrainsData()
    {
        return [
            ['id' => 1, 'name' => 'Chittagong Express', 'number' => 'TR-001', 'from' => 'Dhaka', 'to' => 'Chittagong', 'departure' => '06:00', 'arrival' => '14:30', 'duration' => '8h 30m', 'distance' => '244 km'],
            ['id' => 2, 'name' => 'Chittagong Mail', 'number' => 'TR-002', 'from' => 'Dhaka', 'to' => 'Chittagong', 'departure' => '22:00', 'arrival' => '06:30', 'duration' => '8h 30m', 'distance' => '244 km'],
            ['id' => 3, 'name' => 'Dhaka Express', 'number' => 'TR-003', 'from' => 'Chittagong', 'to' => 'Dhaka', 'departure' => '07:00', 'arrival' => '15:30', 'duration' => '8h 30m', 'distance' => '244 km'],
            ['id' => 4, 'name' => 'Sylhet Express', 'number' => 'TR-004', 'from' => 'Dhaka', 'to' => 'Sylhet', 'departure' => '08:00', 'arrival' => '16:00', 'duration' => '8h 00m', 'distance' => '247 km'],
            ['id' => 5, 'name' => 'Rajshahi Express', 'number' => 'TR-005', 'from' => 'Dhaka', 'to' => 'Rajshahi', 'departure' => '09:00', 'arrival' => '17:30', 'duration' => '8h 30m', 'distance' => '256 km'],
            ['id' => 6, 'name' => 'Khulna Express', 'number' => 'TR-006', 'from' => 'Dhaka', 'to' => 'Khulna', 'departure' => '10:00', 'arrival' => '18:00', 'duration' => '8h 00m', 'distance' => '228 km'],
            ['id' => 7, 'name' => 'Barisal Express', 'number' => 'TR-007', 'from' => 'Dhaka', 'to' => 'Barisal', 'departure' => '11:00', 'arrival' => '19:30', 'duration' => '8h 30m', 'distance' => '234 km'],
            ['id' => 8, 'name' => 'Tangail Express', 'number' => 'TR-008', 'from' => 'Dhaka', 'to' => 'Tangail', 'departure' => '12:00', 'arrival' => '14:30', 'duration' => '2h 30m', 'distance' => '85 km'],
            ['id' => 9, 'name' => 'Sylhet Mail', 'number' => 'TR-009', 'from' => 'Dhaka', 'to' => 'Sylhet', 'departure' => '20:00', 'arrival' => '04:00', 'duration' => '8h 00m', 'distance' => '247 km'],
            ['id' => 10, 'name' => 'Rajshahi Mail', 'number' => 'TR-010', 'from' => 'Dhaka', 'to' => 'Rajshahi', 'departure' => '21:00', 'arrival' => '05:30', 'duration' => '8h 30m', 'distance' => '256 km'],
            ['id' => 11, 'name' => 'Intercity Express', 'number' => 'TR-011', 'from' => 'Dhaka', 'to' => 'Chittagong', 'departure' => '15:00', 'arrival' => '23:30', 'duration' => '8h 30m', 'distance' => '244 km']
        ];
    }

    public function index()
    {
        $trains = $this->getTrainsData();
        return view('trains.index', compact('trains'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'from_station' => 'required|string',
            'to_station' => 'required|string|different:from_station',
            'journey_date' => 'required|date',
            'passengers' => 'required|integer|min:1|max:4'
        ]);

        $allTrains = $this->getTrainsData();
        
        $trains = collect($allTrains)->filter(function($train) use ($request) {
            return $train['from'] === $request->from_station && $train['to'] === $request->to_station;
        })->map(function($train) {
            $prices = ['TR-001' => 850, 'TR-002' => 750, 'TR-003' => 850, 'TR-004' => 900, 'TR-005' => 920, 'TR-006' => 880, 'TR-007' => 870, 'TR-008' => 350, 'TR-009' => 800, 'TR-010' => 820, 'TR-011' => 950];
            $seats = ['TR-001' => 12, 'TR-002' => 8, 'TR-003' => 10, 'TR-004' => 11, 'TR-005' => 13, 'TR-006' => 15, 'TR-007' => 6, 'TR-008' => 16, 'TR-009' => 9, 'TR-010' => 7, 'TR-011' => 14];
            
            return array_merge($train, [
                'price' => $prices[$train['number']] ?? 500,
                'available_seats' => $seats[$train['number']] ?? 10
            ]);
        })->values()->toArray();

        return view('trains.search-results', ['trains' => $trains, 'searchParams' => $request->all()]);
    }

    public function seats($trainId)
    {
        $allTrains = $this->getTrainsData();
        $train = collect($allTrains)->firstWhere('id', (int)$trainId);
        
        if (!$train) {
            abort(404, 'Train not found');
        }
        
        $trainData = array_merge($train, [
            'total_seats' => 16,
            'available_seats' => 14,
            'journey_date' => request('journey_date', now()->format('Y-m-d'))
        ]);

        return view('trains.seats', ['train' => $trainData]);
    }
}
