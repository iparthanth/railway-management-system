<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Trains - Railway System</title>
    <style>
        /* Basic styles, easy to understand */
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .navbar { background:#fff; border-bottom:1px solid #ddd; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#000; text-decoration:none; margin-left:14px; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
        .train { background:#fff; border:1px solid #ddd; border-radius:6px; padding:14px; margin-bottom:12px; }
        .name { color:#28a745; font-weight:700; margin-bottom:4px; }
        .info { color:#555; margin-bottom:10px; }
        .btn { background:#28a745; color:#fff; padding:8px 14px; border-radius:4px; text-decoration:none; }
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
        @foreach($trains as $t)
            <div class="train">
                <div class="name">{{ $t['name'] }} ({{ $t['number'] }})</div>
                <div class="info">
                    <strong>Route:</strong> {{ $t['from'] }} → {{ $t['to'] }} |
                    <strong>Time:</strong> {{ $t['departure'] }} - {{ $t['arrival'] }} |
                    <strong>Duration:</strong> {{ $t['duration'] }} |
                    <strong>Distance:</strong> {{ $t['distance'] }}
                </div>
                <a class="btn" href="{{ route('trains.seats', $t['id']) }}">View Seats</a>
            </div>
        @endforeach
    </div>
</body>
</html>