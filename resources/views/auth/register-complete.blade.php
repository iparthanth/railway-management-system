@extends('layouts.app')

@section('title', 'Complete Registration - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <img src="/placeholder.svg?height=50&width=50" alt="Bangladesh Railway" class="h-12 w-12 mr-3">
                <div>
                    <h1 class="text-xl font-bold text-orange-600">Bangladesh</h1>
                    <p class="text-sm text-orange-500">Railway</p>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Registration</h2>
        </div>

        <!-- Complete Registration Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <p class="text-gray-600 mb-6">Enter the necessary information to complete registration.</p>

            <form method="POST" action="{{ route('register.complete') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Full Name (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" 
                               value="{{ $user->name }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" 
                               readonly>
                    </div>

                    <!-- Mobile Number (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                        <input type="text" 
                               value="{{ $user->mobile }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" 
                               readonly>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="parthan166@gmail.com"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Post Code -->
                    <div>
                        <label for="post_code" class="block text-sm font-medium text-gray-700 mb-2">Post Code</label>
                        <input type="text" 
                               id="post_code" 
                               name="post_code" 
                               value="{{ old('post_code') }}"
                               placeholder="4000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                        @error('post_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  placeholder="Hazari lane, Chittgong,Bangladesh"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Set Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Set Password</label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="HelloTheRe7819"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="passwordIcon" class="fas fa-eye-slash text-gray-400"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="HelloTheRe7819"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 mb-4">
                    COMPLETE REGISTRATION
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-medium">
                        Already Registered?
                    </a>
                </div>
            </form>

            @if($errors->any())
                <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
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
