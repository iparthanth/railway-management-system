<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Railway Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }
        .search-summary {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            color: #333;
        }
        .train-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .train-details {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 14px;
        }
        .book-now-btn {
            background: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        .book-now-btn:hover {
            background: #218838;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Results</h1>

        <div class="search-summary">
            Dhaka → Chittagong on {{ date('d M, Y') }}
        </div>

        <!-- Static train results -->
        <div class="train-card">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #333;">Turna Nishitha (143)</h3>
                <div class="train-details">
                    <span>Departure: 11:30 PM</span>
                    <span>Arrival: 6:40 AM</span>
                    <span>Duration: 7h 10m</span>
                    <span>Available Seats: 45</span>
                </div>
            </div>
            <a href="{{ route('booking.create') }}" class="book-now-btn">Book Now</a>
        </div>

        <div class="train-card">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #333;">Chittagong Express (164)</h3>
                <div class="train-details">
                    <span>Departure: 2:50 PM</span>
                    <span>Arrival: 10:00 PM</span>
                    <span>Duration: 7h 10m</span>
                    <span>Available Seats: 32</span>
                </div>
            </div>
            <a href="{{ route('booking.create') }}" class="book-now-btn">Book Now</a>
        </div>
        
        <div class="train-card">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #333;">Suborono Express (142)</h3>
                <div class="train-details">
                    <span>Departure: 7:15 AM</span>
                    <span>Arrival: 2:40 PM</span>
                    <span>Duration: 7h 25m</span>
                    <span>Available Seats: 28</span>
                </div>
            </div>
            <a href="{{ route('booking.create') }}" class="book-now-btn">Book Now</a>
        </div>

        <div class="back-link">
            <a href="{{ route('home') }}">← Back to Search</a>
        </div>
    </div>
</body>
</html>
