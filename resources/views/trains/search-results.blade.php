<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Railway System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .navbar {
            background-color: #ffffff;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            justify-content: space-between;
        }
        .navbar-brand { color: #28a745; font-size: 22px; font-weight: bold; text-decoration: none; }
        .navbar-nav { display: flex; gap: 30px; }
        .navbar-nav a { color: black; text-decoration: none; font-weight: 500; font-size: 16px; padding: 8px 15px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .train-item { border: 1px solid #ddd; padding: 20px; margin-bottom: 15px; border-radius: 6px; }
        .train-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .train-name { font-size: 20px; font-weight: bold; color: #28a745; }
        .train-time { font-size: 18px; font-weight: bold; color: #333; }
        .train-info { color: #666; margin-bottom: 15px; }
        .btn { background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-size: 16px; }
        .price { font-size: 18px; font-weight: bold; color: #e74c3c; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Railway Management System</a>
        <div class="navbar-nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('trains.index') }}">All Trains</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>🔍 Search Results</h2>
            <p><strong>Route:</strong> {{ $searchParams['from_station'] }} → {{ $searchParams['to_station'] }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($searchParams['journey_date'])->format('l, F j, Y') }}</p>
            <p><strong>Passengers:</strong> {{ $searchParams['passengers'] }}</p>
        </div>

        @if(count($trains) > 0)
            @foreach($trains as $train)
            <div class="train-item">
                <div class="train-header">
                    <div>
                        <div class="train-name">{{ $train['name'] }}</div>
                        <div style="color: #666;">{{ $train['number'] }} • {{ $train['distance'] }}</div>
                    </div>
                    <div class="train-time">{{ $train['departure'] }} - {{ $train['arrival'] }}</div>
                </div>
                
                <div class="train-info">
                    <strong>Duration:</strong> {{ $train['duration'] }} | 
                    <strong>Distance:</strong> {{ $train['distance'] }}
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="price">৳{{ number_format($train['price']) }}</div>
                    <a href="{{ route('trains.seats', $train['id']) }}" class="btn">Select Seats</a>
                </div>
            </div>
            @endforeach
        @else
            <div class="card" style="text-align: center;">
                <h3>No Trains Found</h3>
                <p>No trains available for this route.</p>
                <a href="{{ route('home') }}" class="btn">← Back to Search</a>
            </div>
        @endif
    </div>
</body>
</html>
