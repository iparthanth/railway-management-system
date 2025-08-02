@extends('layouts.app')

@section('title', 'Purchase Ticket - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <img src="/placeholder.svg?height=50&width=50" alt="Bangladesh Railway" class="h-12 w-12 mr-3">
                <div>
                    <h1 class="text-xl font-bold text-orange-600">Bangladesh</h1>
                    <p class="text-sm text-orange-500">Railway</p>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Purchase Ticket</h2>
        </div>

        <!-- Important Notes -->
        <div class="space-y-4 mb-8">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
                <i class="fas fa-info-circle text-green-600 mt-1 mr-3"></i>
                <div>
                    <p class="text-green-800 font-medium">Please Note: Co-passengers' names (as given on their NID / photo ID) are mandatory to complete the ticket purchase process. All passengers MUST carry their NID / photo identification while traveling.</p>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-start">
                <i class="fas fa-clock text-blue-600 mt-1 mr-3"></i>
                <div>
                    <p class="text-blue-800">Please complete the passenger details, review and continue to the payment page within 5 minutes. If you exceed the time limit, you will have to re-initiate the booking process.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="train_id" value="{{ $request->train_id }}">
            <input type="hidden" name="from_station_id" value="{{ $request->from_station_id }}">
            <input type="hidden" name="to_station_id" value="{{ $request->to_station_id }}">
            <input type="hidden" name="journey_date" value="{{ $request->journey_date }}">
            <input type="hidden" name="class_name" value="{{ $request->class_name }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Passenger Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-orange-600">PASSENGER DETAILS</h3>
                            <div class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>
                                <span id="countdown">02:28</span>
                                <span class="text-xs ml-1">Remaining to initiate your payment process</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-700">Passenger 1</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="passenger_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" 
                                           id="passenger_name" 
                                           name="passenger_name" 
                                           value="{{ old('passenger_name', Auth::user()->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                                           required>
                                    @error('passenger_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="passenger_type" class="block text-sm font-medium text-gray-700 mb-1">Passenger Type</label>
                                    <select name="passenger_type" 
                                            id="passenger_type" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                        <option value="adult" {{ old('passenger_type') == 'adult' ? 'selected' : '' }}>Adult</option>
                                        <option value="child" {{ old('passenger_type') == 'child' ? 'selected' : '' }}>Child</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-orange-600 mb-4">CONTACT DETAILS</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                                <input type="text" 
                                       id="mobile" 
                                       name="mobile" 
                                       value="{{ old('mobile', Auth::user()->mobile) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       required>
                                @error('mobile')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Journey Details -->
                <div class="space-y-6">
                    <!-- Journey Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-orange-600 mb-4">JOURNEY DETAILS</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Train:</span>
                                <span class="font-medium">{{ $train->name }} ({{ $train->number }})</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">From:</span>
                                <span class="font-medium">{{ $fromStation->name }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">To:</span>
                                <span class="font-medium">{{ $toStation->name }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($request->journey_date)->format('d M Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Class:</span>
                                <span class="font-medium">{{ $request->class_name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Fare Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-orange-600 mb-4">FARE DETAILS</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ticket Fare:</span>
                                <span>৳{{ number_format($baseFare, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">VAT (15%):</span>
                                <span>৳{{ number_format($vat, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Charge:</span>
                                <span>৳{{ number_format($serviceCharge, 2) }}</span>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total Amount:</span>
                                <span class="text-green-600">৳{{ number_format($totalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        CONTINUE TO PAYMENT
                    </button>
                </div>
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

<script>
// Countdown timer
let timeLeft = 148; // 2:28 in seconds
const countdownElement = document.getElementById('countdown');

const countdown = setInterval(() => {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        alert('Time expired! Please restart the booking process.');
        window.location.href = '{{ route("home") }}';
    }
    timeLeft--;
}, 1000);
</script>
@endsection
