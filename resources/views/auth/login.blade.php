@extends('layouts.app')

@section('title', 'Login - Bangladesh Railway')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <i class="fas fa-train text-primary mb-3" style="font-size: 3rem;"></i>
                            <h1 class="h4 fw-bold text-primary mb-1">Bangladesh Railway</h1>
                            <p class="text-muted small">নির্ভরযোগ্য • আরামদায়ক • সাশ্রয়ী</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="mobile" class="form-label fw-medium">Mobile Number</label>
                                <input type="text" 
                                       id="mobile" 
                                       name="mobile" 
                                       value="{{ old('mobile') }}"
                                       placeholder="01XXXXXXXXX"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       required>
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="position-relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter your password"
                                           class="form-control pe-5 @error('password') is-invalid @enderror"
                                           required>
                                    <button type="button" 
                                            onclick="togglePassword()" 
                                            class="btn btn-link position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                                        <i id="passwordIcon" class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg fw-medium">
                                    Sign In
                                </button>
                            </div>

                            <div class="row text-center">
                                <div class="col-6">
                                    <a href="#" class="text-primary text-decoration-none small">
                                        Forgot your password?
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('register') }}" class="text-primary text-decoration-none small">
                                        Create an account
                                    </a>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a href="#" class="text-primary text-decoration-none small">Forgot Password?</a>
                                <span class="mx-2 text-muted">•</span>
                                <a href="#" class="text-muted text-decoration-none small">Need Help?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    }
}
</script>
@endsection
