@extends('layouts.app')

@section('title', 'Verify OTP - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <!-- OTP Verification Modal Content -->
        <div class="text-center">
            <!-- Icon -->
            <div class="mb-6">
                <img src="/placeholder.svg?height=80&width=80" alt="OTP Verification" class="h-20 w-20 mx-auto">
            </div>

            <h2 class="text-xl font-semibold text-gray-700 mb-4">Enter OTP Code</h2>
            <p class="text-gray-600 mb-6">Please enter the 6-digit code that we sent to your mobile</p>

            <form method="POST" action="{{ route('verify.otp') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                
                <!-- OTP Input -->
                <div class="flex justify-center space-x-2 mb-4">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 0)">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 1)">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 2)">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 3)">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 4)">
                    <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" oninput="moveToNext(this, 5)">
                </div>

                <input type="hidden" name="otp" id="otpValue">

                <!-- Timer -->
                <div class="mb-4">
                    <span id="timer" class="text-gray-500">02:29</span>
                    <form method="POST" action="{{ route('resend.otp') }}" class="inline ml-4">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="text-orange-600 hover:text-orange-700 text-sm">Resend OTP</button>
                    </form>
                </div>

                <!-- Terms -->
                <p class="text-xs text-gray-500 mb-6">
                    By sharing this OTP you are agreeing to Bangladesh Railway's
                    <a href="#" class="text-green-600 hover:text-green-700">Terms & Condition.</a>
                </p>

                <button type="submit" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    CONTINUE
                </button>
            </form>

            @if($errors->any())
                <div class="mt-4 bg-red-50 border border-red-200 rounded-md p-3">
                    <ul class="text-red-600 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mt-4 bg-green-50 border border-green-200 rounded-md p-3">
                    <p class="text-green-600 text-sm">{{ session('success') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function moveToNext(current, index) {
    const inputs = document.querySelectorAll('input[maxlength="1"]');
    
    if (current.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
    }
    
    // Update hidden OTP value
    let otpValue = '';
    inputs.forEach(input => {
        otpValue += input.value;
    });
    document.getElementById('otpValue').value = otpValue;
}

// Timer countdown
let timeLeft = 149; // 2:29 in seconds
const timer = document.getElementById('timer');

const countdown = setInterval(() => {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        timer.textContent = '00:00';
    }
    timeLeft--;
}, 1000);

// Demo OTP for testing (remove in production)
@if(session('registration_otp'))
    console.log('Demo OTP: {{ session('registration_otp') }}');
@endif
</script>
@endsection
