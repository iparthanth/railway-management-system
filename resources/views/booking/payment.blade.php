@extends('layouts.app')

@section('title', 'Payment - Bangladesh Railway')

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
            <h2 class="text-2xl font-bold text-gray-900">Payment</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Methods -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-orange-600 mb-6">SELECT PAYMENT METHOD</h3>
                    
                    <form method="POST" action="{{ route('booking.process-payment', $booking->id) }}">
                        @csrf
                        
                        <!-- Mobile Financial Services -->
                        <div class="mb-8">
                            <h4 class="font-medium text-gray-700 mb-4">Mobile Financial Services</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <!-- bKash -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="bkash" class="sr-only" required>
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-pink-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="bKash" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">bKash</p>
                                    </div>
                                </label>

                                <!-- Nagad -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="nagad" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-orange-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="Nagad" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">Nagad</p>
                                    </div>
                                </label>

                                <!-- Rocket -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="rocket" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-purple-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="Rocket" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">Rocket</p>
                                    </div>
                                </label>

                                <!-- Upay -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="upay" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-red-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="Upay" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">Upay</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Credit/Debit Cards -->
                        <div class="mb-8">
                            <h4 class="font-medium text-gray-700 mb-4">Credit/Debit Cards</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Visa -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="visa" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="Visa" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">Visa</p>
                                    </div>
                                </label>

                                <!-- Mastercard -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="mastercard" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-red-500 transition-colors payment-option">
                                        <img src="/placeholder.svg?height=40&width=80" alt="Mastercard" class="h-10 mx-auto mb-2">
                                        <p class="text-sm font-medium">Mastercard</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            PROCEED TO PAYMENT
                        </button>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="space-y-6">
                <!-- Booking Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-orange-600 mb-4">BOOKING SUMMARY</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">PNR:</span>
                            <span class="font-medium">{{ $booking->pnr }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Train:</span>
                            <span class="font-medium">{{ $booking->train->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route:</span>
                            <span class="font-medium">{{ $booking->fromStation->name }} - {{ $booking->toStation->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">{{ $booking->journey_date->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Class:</span>
                            <span class="font-medium">{{ $booking->class_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Passenger:</span>
                            <span class="font-medium">{{ $booking->passenger_name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-orange-600 mb-4">PAYMENT SUMMARY</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ticket Fare:</span>
                            <span>৳{{ number_format($booking->fare, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">VAT:</span>
                            <span>৳{{ number_format($booking->vat, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service Charge:</span>
                            <span>৳{{ number_format($booking->service_charge, 2) }}</span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total Amount:</span>
                            <span class="text-green-600">৳{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-option input:checked + div {
    border-color: #10b981;
    background-color: #f0fdf4;
}
</style>

<script>
// Handle payment method selection
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove selected class from all options
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('border-green-500', 'bg-green-50');
        });
        
        // Add selected class to chosen option
        if (this.checked) {
            this.nextElementSibling.classList.add('border-green-500', 'bg-green-50');
        }
    });
});
</script>
@endsection
