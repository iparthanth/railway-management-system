<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; }
        .container { max-width: 700px; margin: 40px auto; background: #fff; border:1px solid #ddd; border-radius:6px; padding:20px; }
        .danger { color: #dc3545; font-weight: 700; }
        .btn { background:#6c757d; color:#fff; border:0; border-radius:4px; padding:10px 18px; cursor:pointer; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>Payment Cancelled</h2>
    <p class="danger">You cancelled the payment. Your booking remains pending/unpaid.</p>
    <div>
        <p><strong>Booking Ref:</strong> {{ $booking->booking_reference ?? ('#' . $booking->id) }}</p>
        <p><strong>Total:</strong> {{ number_format((float)$booking->total_amount, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
    </div>
    <div style="margin-top: 14px; display:flex; gap:10px;">
        <a class="btn" href="{{ route('home') }}">Go Home</a>
        <a class="btn" href="{{ route('payment.create', ['booking' => $booking->id]) }}">Try Payment Again</a>
    </div>
</div>
</body>
</html>