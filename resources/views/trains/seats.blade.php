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
                <div class="coach-section">
                    <div class="coach-title">🎫 Coach A - Economy Class</div>
                    <div class="seat-grid">
                        <div class="seat-row">
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="A1" class="seat-checkbox">
                                <div class="seat">A1</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="A2" class="seat-checkbox">
                                <div class="seat">A2</div>
                            </label>
                            <div class="aisle"></div>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="A3" class="seat-checkbox">
                                <div class="seat">A3</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="A4" class="seat-checkbox">
                                <div class="seat">A4</div>
                            </label>
                        </div>
                        
                        <div class="seat-row">
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="B1" class="seat-checkbox">
                                <div class="seat">B1</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="B2" class="seat-checkbox">
                                <div class="seat booked">B2</div>
                            </label>
                            <div class="aisle"></div>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="B3" class="seat-checkbox">
                                <div class="seat">B3</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="B4" class="seat-checkbox">
                                <div class="seat">B4</div>
                            </label>
                        </div>
                        
                        <div class="seat-row">
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="C1" class="seat-checkbox">
                                <div class="seat">C1</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="C2" class="seat-checkbox">
                                <div class="seat">C2</div>
                            </label>
                            <div class="aisle"></div>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="C3" class="seat-checkbox">
                                <div class="seat booked">C3</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="C4" class="seat-checkbox">
                                <div class="seat">C4</div>
                            </label>
                        </div>
                        
                        <div class="seat-row">
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="D1" class="seat-checkbox">
                                <div class="seat">D1</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="D2" class="seat-checkbox">
                                <div class="seat">D2</div>
                            </label>
                            <div class="aisle"></div>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="D3" class="seat-checkbox">
                                <div class="seat">D3</div>
                            </label>
                            <label class="seat-label">
                                <input type="checkbox" name="seats[]" value="D4" class="seat-checkbox">
                                <div class="seat">D4</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn">Confirm Selection</button>
                    <a href="javascript:history.back()" class="btn btn-back" style="margin-left: 15px;">← Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
