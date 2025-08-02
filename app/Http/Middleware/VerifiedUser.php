<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }
        
        // Check if user's mobile is verified
        if (!$user->mobile_verified) {
            return redirect()->route('auth.verify-mobile')
                ->with('error', 'Please verify your mobile number to continue.');
        }
        
        // Optional: Check if user's NID is verified for sensitive operations
        $requiresNidVerification = $request->route() && 
            in_array($request->route()->getName(), [
                'booking.create',
                'booking.store',
                'payment.process'
            ]);
            
        if ($requiresNidVerification && !$user->nid_verified) {
            return redirect()->route('auth.verify-nid')
                ->with('error', 'Please verify your NID to proceed with booking.');
        }
        
        return $next($request);
    }
}
