<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats - {{ $train['name'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .navbar { background:#fff; border-bottom:1px solid #ddd; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#000; text-decoration:none; margin-left:14px; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 800px; margin: 20px auto; padding: 0 16px; }
        .card { background:#fff; border:1px solid #ddd; border-radius:6px; padding:14px; margin-bottom:12px; }
        .date-strip { display:flex; gap:8px; overflow-x:auto; padding:6px 0; }
        .date-pill { padding:8px 12px; border:1px solid #e0e0e0; border-radius:18px; text-decoration:none; color:#333; background:#f0f0f0; }
        .date-pill.active { background:#28a745; color:#fff; border-color:#28a745; }
        .date-pill.full { background:#dc3545; color:#fff; border-color:#dc3545; }
        .meta { font-size:12px; color:#666; margin-top:6px; }
        .legend { display:flex; gap:14px; }
        .legend .box { width:22px; height:22px; border-radius:4px; }
        .avail { background:#28a745; }
        .sel { background:#007bff; }
        .book { background:#dc3545; }
        .grid { max-width: 320px; margin: 0 auto; }
        .row { display:flex; gap:10px; justify-content:center; margin-bottom:10px; }
        .seat { width:40px; height:40px; border:2px solid #28a745; background:#28a745; color:#fff; border-radius:6px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; }
        .seat.booked { background:#dc3545; border-color:#dc3545; pointer-events:none; cursor:not-allowed; }
        .aisle { width:20px; color:#ccc; display:flex; align-items:center; justify-content:center; }
        .btn { background:#28a745; color:#fff; border:0; border-radius:4px; padding:10px 18px; cursor:pointer; }
        .btn.back { background:#6c757d; }
        input.seat-checkbox { display:none; }
        input.seat-checkbox:checked + .seat { background:#007bff; border-color:#007bff; }
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
            <h2>Select Your Seats</h2>
            <p style="color:#28a745; font-weight:700;">{{ $train['name'] }} ({{ $train['number'] }})</p>
            <p><strong>Route:</strong> {{ $train['from'] }} → {{ $train['to'] }}</p>
        </div>

        <div class="card">
            <h3>Choose Date (7 days)</h3>
            <div class="date-strip">
                @foreach($week as $d)
                    @php
                        $isActive = $d['date'] === $selectedDate;
                        $cls = 'date-pill' . ($isActive ? ' active' : '') . ($d['is_full'] ? ' full' : '');
                    @endphp
                    <a class="{{ $cls }}" href="{{ route('trains.seats', ['id' => $train['id'], 'journey_date' => $train['journey_date'], 'date' => $d['date']]) }}">{{ $d['label'] }}</a>
                @endforeach
            </div>
            <div class="meta">
                @php $cur = collect($week)->firstWhere('date', $selectedDate); @endphp
                @if($cur)
                    <span><strong>{{ $cur['available'] }}</strong> available • <strong>{{ $cur['booked_count'] }}</strong> booked</span>
                    @if($cur['is_full']) <span style="color:#dc3545; font-weight:700;"> — Fully Booked</span> @endif
                @endif
            </div>
        </div>

        <div class="card">
            <h3>Seat Legend</h3>
            <div class="legend">
                <div style="display:flex; align-items:center; gap:6px;">
                    <div class="box avail"></div><span>Available</span>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <div class="box sel"></div><span>Selected</span>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <div class="box book"></div><span>Booked</span>
                </div>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="#">
                @csrf
                <input type="hidden" name="date" value="{{ $selectedDate }}">

                <div style="text-align:center; font-weight:700; margin-bottom:10px;">Coach A - Economy Class</div>
                <div class="grid">
                    @php
                        $seats = ['A1','A2','A3','A4','B1','B2','B3','B4','C1','C2','C3','C4','D1','D2','D3','D4'];
                        $rows = array_chunk($seats, 4);
                    @endphp

                    @foreach($rows as $row)
                        <div class="row">
                            @foreach($row as $i => $seat)
                                @if($i === 2)
                                    <div class="aisle">||</div>
                                @endif
                                @php $taken = in_array($seat, $bookedSeats); @endphp
                                <label>
                                    <input class="seat-checkbox" type="checkbox" name="seats[]" value="{{ $seat }}" @if($taken) disabled @endif>
                                    <div class="seat @if($taken) booked @endif">{{ $seat }}</div>
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div style="text-align:center; margin-top:16px;">
                    <button type="submit" class="btn" @if($isFullyBooked) disabled style="opacity:0.6; cursor:not-allowed;" @endif>Confirm Selection</button>
                    <a class="btn back" href="javascript:history.back()" style="margin-left:12px;">← Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>