<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .navbar { background:#fff; border-bottom:1px solid #ddd; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#000; text-decoration:none; margin-left:14px; }
        .navbar .links { display:inline-flex; align-items:center; }
        .navbar .links form { display:inline; margin:0; }
        .navbar .links button { background:none; border:none; color:#000; margin-left:14px; cursor:pointer; padding:0; font: inherit; }
        .brand { color:#28a745; font-weight:700; }
        .container { max-width: 700px; margin: 20px auto; background: #fff; border:1px solid #ddd; border-radius:6px; padding:20px; }
        .ok { color: #28a745; font-weight: 700; }
        .warn { color: #6c757d; font-weight: 700; }
        .btn { background:#28a745; color:#fff; border:0; border-radius:4px; padding:10px 18px; cursor:pointer; text-decoration: none; }
    </style>
</head>
<body>
<div class="navbar">
    <a href="{{ route('home') }}" class="brand">Railway Management System</a>
    <div class="links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('trains.index') }}">All Trains</a>
        <a href="{{ route('bookings.index') }}">Bookings</a>
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
    <h2>{{ $paid ? 'Booking Confirmed' : 'Payment Status' }}</h2>
    <p class="{{ $paid ? 'ok' : 'warn' }}">{{ $message }}</p>
    @if($paid)
        <p class="ok">Your booking has been created successfully.</p>
    @endif
    <div>
        <p><strong>Booking Ref:</strong> {{ $booking->booking_reference ?? ('#' . $booking->id) }}</p>
        <p><strong>Total {{ $paid ? 'Paid' : 'Amount' }}:</strong> {{ strtoupper(env('STRIPE_CURRENCY', 'usd')) }} {{ number_format((float)$booking->total_amount, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
    </div>
    <div style="margin-top: 14px; display:flex; gap:10px;">
        <a class="btn" href="{{ route('home') }}">Go Home</a>
        <a class="btn" href="{{ route('bookings.show', ['id' => $booking->id]) }}">View Booking</a>
    </div>
</div>
</body>
</html>