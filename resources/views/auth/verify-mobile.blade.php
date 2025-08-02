@extends('layouts.app')

@section('title', 'Verify Mobile Number')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Verify Mobile Number</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Verification Required</strong>
                        <p class="mb-0 mt-1">Please verify your mobile number to continue using the service.</p>
                    </div>
                    
                    <p class="text-muted mb-4">
                        We'll send a 6-digit OTP to your mobile number 
                        <strong>{{ $user->masked_mobile }}</strong>
                    </p>
                    
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (!$user->hasActiveOtp())
                        <!-- Send OTP Form -->
                        <form method="POST" action="{{ route('auth.send-mobile-otp') }}">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Send OTP</button>
                            </div>
                        </form>
                    @else
                        <!-- Verify OTP Form -->
                        <form method="POST" action="{{ route('auth.verify-mobile-otp') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" 
                                       class="form-control text-center @error('otp') is-invalid @enderror" 
                                       id="otp" 
                                       name="otp" 
                                       maxlength="6"
                                       placeholder="000000"
                                       style="letter-spacing: 0.5em; font-size: 1.5rem;"
                                       required>
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    OTP expires in <span id="countdown">{{ $user->getOtpRemainingTime() }}</span> seconds
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-success">Verify OTP</button>
                            </div>
                        </form>

                        <!-- Resend OTP -->
                        <div class="text-center">
                            <p class="mb-2">Didn't receive OTP?</p>
                            <form method="POST" action="{{ route('auth.resend-mobile-otp') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">Resend OTP</button>
                            </form>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <a href="{{ route('logout') }}" class="text-decoration-none"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($user->hasActiveOtp())
<script>
// Countdown timer
let timeLeft = {{ $user->getOtpRemainingTime() }};
const countdownElement = document.getElementById('countdown');

const timer = setInterval(function() {
    if (timeLeft <= 0) {
        clearInterval(timer);
        location.reload(); // Reload to show "Send OTP" button again
    } else {
        countdownElement.textContent = timeLeft;
        timeLeft--;
    }
}, 1000);

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endif
@endsection
