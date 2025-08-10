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
            padding: 1px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            justify-content: space-between;
        }
        .navbar-brand {
            color: #28a745;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar-nav a {
            color: black;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        .navbar-nav a:hover {
            color: #28a745;
        }
        .user-info {
            color: black;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 10px;
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
        input[type="submit"]:hover {
            background-color: #218838;
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

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="navbar-brand">Railway Management System</a>
        <div class="navbar-nav">
            <a href="#">Home</a>
        </div>
        <div class="user-info">
            <span>Welcome, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <input type="submit" value="Logout" class="logout-btn">
            </form>
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

        <form id="searchForm" action="{{ route('search.trains') }}" method="POST">
            @csrf
            <label for="fromStation">From:</label>
            <select id="fromStation" name="from_station" required>
                <option value="">Select departure</option>
                <option value="dhaka">Dhaka</option>
                <option value="chittagong">Chittagong</option>
                <option value="sylhet">Sylhet</option>
                <option value="rajshahi">Rajshahi</option>
                <option value="khulna">Khulna</option>
                <option value="barisal">Barisal</option>
            </select>

            <label for="toStation">To:</label>
            <select id="toStation" name="to_station" required>
                <option value="">Select destination</option>
                <option value="dhaka">Dhaka</option>
                <option value="chittagong">Chittagong</option>
                <option value="sylhet">Sylhet</option>
                <option value="rajshahi">Rajshahi</option>
                <option value="khulna">Khulna</option>
                <option value="barisal">Barisal</option>
            </select>

            <label for="journeyDate">Journey Date:</label>
            <input type="date" id="journeyDate" name="travel_date" required>

            <label for="trainClass">Class:</label>
            <select id="trainClass" name="class">
                <option value="">All Classes</option>
                <option value="AC_B">AC Berth</option>
                <option value="AC_S">AC Seat</option>
                <option value="SNIGDHA">Snigdha</option>
                <option value="F_BERTH">First Berth</option>
                <option value="F_SEAT">First Seat</option>
                <option value="S_CHAIR">Shovan Chair</option>
            </select>

            <input type="submit" value="Search Trains">
        </form>
        
        
    </div>

    

</body>
</html>
