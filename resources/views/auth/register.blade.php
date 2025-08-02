@extends('layouts.app')

@section('title', 'Registration - Bangladesh Railway')

@section('content')
<div class="min-vh-100 bg-light py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-train text-primary me-2" style="font-size: 2rem;"></i>
                        <div>
                            <h1 class="h4 fw-bold text-primary mb-0">Bangladesh Railway</h1>
                        </div>
                    </div>
                    <h2 class="h3 fw-bold text-dark mb-2">Registration</h2>
                </div>

                <!-- Registration Form -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <!-- Verification Icon -->
                        <div class="text-center mb-4">
                            <i class="fas fa-user-check text-primary mb-3" style="font-size: 3rem;"></i>
                            <h3 class="h5 fw-semibold text-dark mb-2">Please Verify Your NID</h3>
                            <p class="text-muted small mb-1">Enter the information below to verify and register</p>
                            <p class="text-muted small mb-3">your NID with Bangladesh Railway Ticketing Service</p>
                            <p class="text-muted" style="font-size: 0.875rem;">If your NID is verified through SMS, please use the</p>
                            <p class="text-muted" style="font-size: 0.875rem;">details used during the SMS verification.</p>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info d-flex align-items-start mb-4">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong>Please enter your full name exactly as it appears on your NID card.</strong>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <!-- Full Name -->
                                <label for="name" class="form-label fw-medium">Enter Full Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       placeholder="Enter Full Name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Mobile Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="mobile" class="form-label fw-medium">Enter Mobile Number</label>
                                    <input type="text" 
                                           id="mobile" 
                                           name="mobile" 
                                           value="{{ old('mobile') }}"
                                           placeholder="Enter Mobile Number"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           required>
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- NID Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="nid_number" class="form-label fw-medium">Enter NID Number</label>
                                    <input type="text" 
                                           id="nid_number" 
                                           name="nid_number" 
                                           value="{{ old('nid_number') }}"
                                           placeholder="Enter NID Number"
                                           class="form-control @error('nid_number') is-invalid @enderror"
                                           required>
                                    @error('nid_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-4">
                                <label for="date_of_birth" class="form-label fw-medium">Select Date of Birth</label>
                                <input type="date" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth') }}"
                                       placeholder="mm/dd/yyyy"
                                       class="form-control @error('date_of_birth') is-invalid @enderror"
                                       required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg fw-medium">
                                    Verify
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">If you are under 18 years old or a foreign</p>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">passport holder, you can register with your</p>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">birth certificate or passport by clicking the</p>
                                <p class="text-muted mb-3" style="font-size: 0.9rem;">submit data button.</p>
                                
                                <button type="button" class="btn btn-success fw-medium mb-3">
                                    SUBMIT DATA
                                </button>
                                
                                <div>
                                    <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-medium">
                                        Already Registered?
                                    </a>
                                </div>
                            </div>
                        </form>

                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0 list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
