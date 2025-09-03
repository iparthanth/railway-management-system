<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Railway - Home</title>
    <style>
        /* Simple styles to keep things readable */
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f4f0; /* fallback color */
            background-image: url('{{ asset('images/train-bg.jpg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }
        .navbar { background: #fff; border-bottom: 1px solid #ddd; padding: 12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { text-decoration: none; color: #000; margin-left: 14px; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 460px; margin: 24px auto; background:#fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        h1 { color:#28a745; font-size: 22px; margin: 0 0 8px; text-align:center; }
        label { display:block; margin-top: 12px; font-weight:600; }
        select, input[type="date"] { width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; margin-top:6px; }
        button { width:100%; background:#28a745; color:#fff; padding:12px; border:0; border-radius:6px; margin-top:16px; cursor:pointer; }
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
        <h1>Search for Trains</h1>
        <form id="searchForm" action="{{ route('trains.search') }}" method="POST">
            @csrf
            <label for="fromStation">From</label>
            <select id="fromStation" name="from_station" required>
                <option value="">Select departure</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chittagong">Chittagong</option>
                <option value="Sylhet">Sylhet</option>
                <option value="Rajshahi">Rajshahi</option>
                <option value="Khulna">Khulna</option>
                <option value="Barisal">Barisal</option>
                <option value="Tangail">Tangail</option>
            </select>

            <label for="toStation">To</label>
            <select id="toStation" name="to_station" required>
                <option value="">Select destination</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chittagong">Chittagong</option>
                <option value="Sylhet">Sylhet</option>
                <option value="Rajshahi">Rajshahi</option>
                <option value="Khulna">Khulna</option>
                <option value="Barisal">Barisal</option>
                <option value="Tangail">Tangail</option>
            </select>

            <label for="journeyDate">Journey Date</label>
            <input type="date" id="journeyDate" name="journey_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

            <label for="passengers">Passengers</label>
            <select id="passengers" name="passengers" required>
                <option value="1">1 Passenger</option>
                <option value="2">2 Passengers</option>
                <option value="3">3 Passengers</option>
                <option value="4">4 Passengers (Maximum)</option>
            </select>

            <button type="submit">Search Trains</button>
        </form>
    </div>

    <script>
        // Small validation so user can't choose same stations
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            var fromStation = document.getElementById('fromStation').value;
            var toStation = document.getElementById('toStation').value;
            if (!fromStation || !toStation) {
                e.preventDefault();
                alert('Please select both departure and destination stations.');
                return;
            }
            if (fromStation === toStation) {
                e.preventDefault();
                alert('Please select different stations.');
                return;
            }
        });
    </script>
</body>
</html>