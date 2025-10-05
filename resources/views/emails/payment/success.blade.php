<!DOCTYPE html>
<html>
  <body>
    <p>Hello {{ $booking->passenger_name ?? 'Passenger' }},</p>
    <p>Your payment was successful. Here are your booking details:</p>
    <ul>
      <li>Reference: {{ $booking->booking_reference ?? '#'.$booking->id }}</li>
      <li>Journey date: {{ optional($booking->journey_date)->format('Y-m-d') }}</li>
      <li>Total paid: {{ number_format((float)$booking->total_amount, 2) }}</li>
      @if($booking->train) <li>Train: {{ $booking->train->name ?? $booking->train->id }}</li> @endif
      @if($booking->route) <li>Route: {{ $booking->route->from ?? '' }} → {{ $booking->route->to ?? '' }}</li> @endif
    </ul>
    <p>Thank you for booking with us.</p>
  </body>
</html>