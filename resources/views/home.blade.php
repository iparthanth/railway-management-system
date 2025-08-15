<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Railway - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('{{ asset('images/train-bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: white;
            position: relative;
        }
        /* Dark overlay for better text readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }
        .navbar {
            background-color: #ffffff;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            justify-content: space-between;
            min-height: 70px;
        }
        .navbar-brand {
            color: #28a745;
            font-size: 22px;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar-nav {
            display: flex;
            gap: 30px;
        }
        .navbar-nav a {
            color: black;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .container {
            max-width: 450px;
            margin: 30px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            color: #333;
        }
        h1, h2 {
            text-align: center;
            color: #28a745;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        select, input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .welcome-text {
            text-align: center;
            font-size: 36px;
            color: white;
            text-shadow: 2px 2px 4px #000;
            margin: 20px 0;
            line-height: 1.2;
        }

        .welcome-text .highlight {
            color: #ffd700;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px 20px;
            }
            .navbar-nav {
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            .container {
                margin: 20px;
                max-width: none;
            }
            .welcome-text {
                font-size: 28px;
                margin: 15px 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Railway Management System</a>
        <div class="navbar-nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('trains.index') }}">All Trains</a>
        </div>
    </div>

    <!-- Welcome Text -->
    <div class="welcome-text">
        <span class="highlight">Bangladesh</span><br>
        Railway System
    </div>

    <!-- Search Form Container -->
    <div class="container">
        <h2>Search for Trains</h2>

        <form id="searchForm" action="{{ route('trains.search') }}" method="POST">
            @csrf
            <label for="fromStation">From:</label>
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

            <label for="toStation">To:</label>
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

            <label for="journeyDate">Journey Date:</label>
            <input type="date" id="journeyDate" name="journey_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

            <label for="passengers">Number of Passengers:</label>
            <select id="passengers" name="passengers" required>
                <option value="1">1 Passenger</option>
                <option value="2">2 Passengers</option>
                <option value="3">3 Passengers</option>
                <option value="4">4 Passengers (Maximum)</option>
            </select>

            <input type="submit" value="Search Trains">
        </form>
    </div>

    <script>
        // Form validation
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            const fromStation = document.getElementById('fromStation').value;
            const toStation = document.getElementById('toStation').value;

            if (fromStation === toStation) {
                e.preventDefault();
                alert('Please select different departure and destination stations.');
                return false;
            }

            if (!fromStation || !toStation) {
                e.preventDefault();
                alert('Please select both departure and destination stations.');
                return false;
            }
        });
    </script>

</body>
</html>
