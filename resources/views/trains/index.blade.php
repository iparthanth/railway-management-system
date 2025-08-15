<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Trains - Railway System</title>
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
        .train-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 6px; }
        .train-name { font-size: 18px; font-weight: bold; color: #28a745; margin-bottom: 5px; }
        .train-info { color: #666; margin-bottom: 10px; }
        .btn { background-color: #28a745; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-size: 14px; }
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
        @foreach($trains as $train)
        <div class="train-item">
            <div class="train-name">{{ $train['name'] }} ({{ $train['number'] }})</div>
            <div class="train-info">
                <strong>Route:</strong> {{ $train['from'] }} → {{ $train['to'] }} | 
                <strong>Time:</strong> {{ $train['departure'] }} - {{ $train['arrival'] }} | 
                <strong>Duration:</strong> {{ $train['duration'] }} | 
                <strong>Distance:</strong> {{ $train['distance'] }}
            </div>
            <a href="{{ route('trains.seats', $train['id']) }}" class="btn">View Seats</a>
        </div>
        @endforeach
    </div>
</body>
</html>
