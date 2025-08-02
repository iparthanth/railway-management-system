<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function verify()
    {
        return view('verify-ticket');
    }

    public function checkTicket(Request $request)
    {
        $request->validate([
            'ticket_type' => 'required|in:online,counter',
            'pnr' => 'required|string',
            'mobile' => 'required_if:ticket_type,online|string',
        ]);

        $query = Booking::where('pnr', $request->pnr);
        
        if ($request->ticket_type === 'online') {
            $query->where('mobile', $request->mobile);
        }

        $booking = $query->with(['train', 'fromStation', 'toStation', 'payment'])->first();

        if (!$booking) {
            return back()->withErrors(['pnr' => 'Ticket not found with provided information.']);
        }

        return view('ticket-details', compact('booking'));
    }
}
