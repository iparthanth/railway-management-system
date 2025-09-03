<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Info - {{ $train->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .navbar { background:#fff; border-bottom:1px solid #ddd; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#000; text-decoration:none; margin-left:14px; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 800px; margin: 20px auto; padding: 0 16px; }
        .card { background:#fff; border:1px solid #ddd; border-radius:6px; padding:14px; margin-bottom:12px; }
        .row { display:flex; gap:12px; margin-bottom:10px; }
        input[type=text], select { padding:8px; border:1px solid #ccc; border-radius:4px; width:100%; }
        .btn { background:#28a745; color:#fff; border:0; border-radius:4px; padding:10px 18px; cursor:pointer; }
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
            <h2>Passenger Information</h2>
            <p><strong>Train:</strong> {{ $train->name }} ({{ $train->number }})</p>
            @if($route)
                <p><strong>Route:</strong> {{ $route->fromStation->name ?? '-' }} → {{ $route->toStation->name ?? '-' }}</p>
            @endif
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($journey_date)->format('l, F j, Y') }}</p>
            <p><strong>Seats:</strong> {{ implode(', ', $selected_seats) }}</p>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('trains.book', ['id' => $train->id]) }}">
                @csrf
                <input type="hidden" name="journey_date" value="{{ $journey_date }}">
                <input type="hidden" name="route_id" value="{{ $route->id ?? '' }}">
                @foreach($selected_seats as $s)
                    <input type="hidden" name="seats[]" value="{{ $s }}">
                @endforeach

                @for($i = 0; $i < count($selected_seats); $i++)
                    <div class="row">
                        <div style="flex:2;">
                            <label>Passenger {{ $i + 1 }} Name</label>
                            <input type="text" name="passengers[{{ $i }}][name]" required placeholder="Enter name">
                        </div>
                        <div style="flex:1;">
                            <label>Type</label>
                            <select name="passengers[{{ $i }}][type]" required>
                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                            </select>
                        </div>
                    </div>
                @endfor

                <div style="text-align:right;">
                    <button class="btn" type="submit">Save Booking</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>