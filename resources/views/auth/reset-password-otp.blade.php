@extends('layouts.app')

@section('title', 'Verify OTP - Password Reset')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Verify OTP</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        We've sent a 6-digit OTP to your mobile number 
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

                    <form method="POST" action="{{ route('password.verify-otp') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        
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
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Verify OTP</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-2">Didn't receive OTP?</p>
                        <form method="POST" action="{{ route('password.resend-otp') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0">Resend OTP</button>
                        </form>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('forgot.password') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endsection
