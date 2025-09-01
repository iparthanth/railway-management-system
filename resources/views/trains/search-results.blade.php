<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Railway System</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .navbar { background:#fff; border-bottom:1px solid #ddd; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#000; text-decoration:none; margin-left:14px; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
        .card { background:#fff; border:1px solid #ddd; border-radius:6px; padding:14px; margin-bottom:12px; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
        .name { color:#28a745; font-weight:700; }
        .time { font-weight:700; }
        .price { color:#e74c3c; font-weight:700; }
        .btn { background:#28a745; color:#fff; padding:8px 14px; border-radius:4px; text-decoration:none; }
        .muted { color:#666; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('home') }}" class="brand">Railway Management System</a>
        <div>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('trains.index') }}">All Trains</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Search Results</h2>
            <p><strong>Route:</strong> {{ $searchParams['from_station'] }} → {{ $searchParams['to_station'] }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($searchParams['journey_date'])->format('l, F j, Y') }}</p>
            <p><strong>Passengers:</strong> {{ $searchParams['passengers'] }}</p>
        </div>

        @if(count($trains) > 0)
            @foreach($trains as $t)
                <div class="card">
                    <div class="header">
                        <div>
                            <div class="name">{{ $t['name'] }}</div>
                            <div class="muted">{{ $t['number'] }} • {{ $t['distance'] }}</div>
                        </div>
                        <div class="time">{{ $t['departure'] }} - {{ $t['arrival'] }}</div>
                    </div>
                    <div class="muted" style="margin-bottom:8px;">
                        <strong>Duration:</strong> {{ $t['duration'] }}
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div class="price">৳{{ number_format($t['price']) }}</div>
                        <a class="btn" href="{{ route('trains.seats', ['id' => $t['id'], 'journey_date' => $searchParams['journey_date'], 'passengers' => $searchParams['passengers'], 'route_id' => $t['route_id'] ?? null]) }}">Select Seats</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card" style="text-align:center;">
                <h3>No Trains Found</h3>
                <p>No trains available for this route.</p>
                <a class="btn" href="{{ route('home') }}">← Back to Search</a>
            </div>
        @endif
    </div>
</body>
</html>