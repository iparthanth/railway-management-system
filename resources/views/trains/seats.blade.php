<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats - {{ $train['name'] }}</title>
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
        .container { max-width: 800px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        
        .seat-legend { display: flex; gap: 20px; margin-bottom: 20px; }
        .legend-item { display: flex; align-items: center; gap: 8px; }
        .legend-seat { width: 25px; height: 25px; border-radius: 4px; }
        .available { background-color: #28a745; }
        .selected { background-color: #007bff; }
        .booked { background-color: #dc3545; }
        
        .date-strip { display: flex; gap: 10px; overflow-x: auto; padding: 10px 0; }
        .date-pill {
            padding: 8px 12px; border-radius: 20px; background: #f0f0f0; cursor: pointer;
            text-decoration: none; color: #333; border: 1px solid #e0e0e0;
        }
        .date-pill.active { background: #28a745; color: white; border-color: #28a745; }
        .date-pill.full { background: #dc3545; color: white; border-color: #dc3545; }
        .date-meta { font-size: 12px; color: #666; margin-top: 6px; }

        .coach-section { margin-bottom: 30px; }
        .coach-title { background: #f8f9fa; padding: 10px; text-align: center; font-weight: bold; border-radius: 5px; margin-bottom: 15px; }
        .seat-grid { max-width: 300px; margin: 0 auto; }
        .seat-row { display: flex; justify-content: center; gap: 10px; margin-bottom: 10px; }
        
        .seat-label { cursor: pointer; }
        .seat-checkbox { display: none; }
        .seat {
            width: 40px;
            height: 40px;
            border: 2px solid #ddd;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
        .seat.booked {
            background-color: #dc3545;
            border-color: #dc3545;
            cursor: not-allowed;
            pointer-events: none;
        }
        .seat-checkbox:checked + .seat {
            background-color: #007bff;
            border-color: #007bff;
        }
        .aisle { width: 20px; height: 40px; display: flex; align-items: center; justify-content: center; color: #ccc; }
        .aisle::after { content: "||"; }
        
        .btn { background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-size: 16px; border: none; cursor: pointer; }
        .btn-back { background-color: #6c757d; }
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
            <h2>Select Your Seats</h2>
            <h3 style="color: #28a745; margin-bottom: 10px;">{{ $train['name'] }} ({{ $train['number'] }})</h3>
            <p><strong>Route:</strong> {{ $train['from'] }} → {{ $train['to'] }}</p>
        </div>

        <div class="card">
            <h3>Choose Date (7 days)</h3>
            <div class="date-strip">
                @foreach($week as $day)
                    @php
                        $active = $day['date'] === $selectedDate;
                        $classes = 'date-pill' . ($active ? ' active' : '') . ($day['is_full'] ? ' full' : '');
                    @endphp
                    <a class="{{ $classes }}" href="{{ route('trains.seats', ['id' => $train['id'], 'journey_date' => $train['journey_date'], 'date' => $day['date']]) }}">{{ $day['label'] }}</a>
                @endforeach
            </div>
            <div class="date-meta">
                @php $current = collect($week)->firstWhere('date', $selectedDate); @endphp
                @if($current)
                    <span><strong>{{ $current['available'] }}</strong> available • <strong>{{ $current['booked_count'] }}</strong> booked</span>
                    @if($current['is_full']) <span style="color:#dc3545; font-weight:bold;"> — Fully Booked</span> @endif
                @endif
            </div>
        </div>

        <div class="card">
            <h3>Seat Legend</h3>
            <div class="seat-legend">
                <div class="legend-item">
                    <div class="legend-seat available"></div>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat selected"></div>
                    <span>Selected</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat booked"></div>
                    <span>Booked</span>
                </div>
            </div>
        </div>

        <div class="card">
            <form action="#" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ $selectedDate }}">
                <div class="coach-section">
                    <div class="coach-title">🎫 Coach A - Economy Class</div>
                    <div class="seat-grid">
                        @php
                            $seats = ['A1','A2','A3','A4','B1','B2','B3','B4','C1','C2','C3','C4','D1','D2','D3','D4'];
                            $rows = array_chunk($seats, 4);
                        @endphp
                        @foreach($rows as $i => $row)
                            <div class="seat-row">
                                @foreach($row as $idx => $seat)
                                    @if($idx === 2)
                                        <div class="aisle"></div>
                                    @endif
                                    <label class="seat-label">
                                        @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                        <input type="checkbox" name="seats[]" value="{{ $seat }}" class="seat-checkbox" @if($isBooked) disabled @endif>
                                        <div class="seat @if($isBooked) booked @endif">{{ $seat }}</div>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn" @if($isFullyBooked) disabled style="opacity:0.6; cursor:not-allowed;" @endif>Confirm Selection</button>
                    <a href="javascript:history.back()" class="btn btn-back" style="margin-left: 15px;">← Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
