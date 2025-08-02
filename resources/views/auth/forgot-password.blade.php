@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Forgot Password</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Enter your mobile number to receive an OTP for password reset.</p>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.send-otp') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="text" 
                                   class="form-control @error('mobile') is-invalid @enderror" 
                                   id="mobile" 
                                   name="mobile" 
                                   value="{{ old('mobile') }}" 
                                   placeholder="01XXXXXXXXX"
                                   pattern="^01[3-9]\d{8}$"
                                   required>
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter your registered mobile number</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Send OTP</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
