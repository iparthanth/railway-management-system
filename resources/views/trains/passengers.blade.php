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
        .navbar .links { display:inline-flex; align-items:center; }
        .navbar .links form { display:inline; margin:0; }
        .navbar .links button { background:none; border:none; color:#000; margin-left:14px; cursor:pointer; padding:0; font: inherit; }
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
        <div class="links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('trains.index') }}">All Trains</a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
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
            @if($route)
                <p><strong>Price per ticket:</strong> USD {{ number_format($route->base_price, 2) }}</p>
                <p><strong>Total:</strong> USD <span id="totalAmount">{{ number_format($route->base_price * count($selected_seats), 2) }}</span></p>
            @else
                <p style="color:#dc3545;"><strong>Price:</strong> Unavailable for this selection</p>
            @endif
        </div>

        <div class="card">
            <form method="POST" action="{{ route('trains.book', ['id' => $train->id]) }}">
                @csrf
                <input type="hidden" name="journey_date" value="{{ $journey_date }}">
                <input type="hidden" name="route_id" value="{{ $route->id ?? '' }}">
                @foreach($selected_seats as $s)
                    <input type="hidden" name="seats[]" value="{{ $s }}">
                @endforeach

                <div class="row">
                    <div style="flex:1;">
                        <label>Contact Email</label>
                        <input type="text" name="contact_email" required placeholder="name@example.com">
                    </div>
                    <div style="flex:1;">
                        <label>Contact Phone</label>
                        <input type="text" name="contact_phone" required placeholder="e.g. +1 555 123 4567">
                    </div>
                </div>

                @for($i = 0; $i < count($selected_seats); $i++)
                    <div class="row">
                        <div style="flex:2;">
                            <label>Passenger {{ $i + 1 }} Name</label>
                            <input type="text" name="passengers[{{ $i }}][name]" required placeholder="Enter name">
                        </div>
                        <div style="flex:1;">
                            <label>Type</label>
                            <select class="ptype" name="passengers[{{ $i }}][type]" required>
                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                            </select>
                        </div>
                    </div>
                @endfor

                @if($route)
                    <div style="text-align:right; margin-top:8px; color:#333;">
                        <small>Child = 50% of base price</small>
                    </div>
                @endif

                <div style="text-align:right;">
                    <button class="btn" type="submit">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
    @if($route)
    <script>
        // Live total calculation: adult = 1x, child = 0.5x of base
        (function(){
            var base = {{ (float)($route->base_price ?? 0) }};
            function recalc(){
                var selects = document.querySelectorAll('select.ptype');
                var total = 0;
                for (var i = 0; i < selects.length; i++) {
                    total += (selects[i].value === 'child') ? base * 0.5 : base;
                }
                var el = document.getElementById('totalAmount');
                if (el) el.textContent = total.toFixed(2);
            }
            document.addEventListener('change', function(e){
                if (e.target && e.target.matches('select.ptype')) recalc();
            });
            // Initial calc in case server-side count changed
            recalc();
        })();
    </script>
    @endif
</body>
</html>