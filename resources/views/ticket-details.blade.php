@extends('layouts.app')

@section('title', 'Ticket Details - Bangladesh Railway')

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
            <h2 class="text-2xl font-bold text-gray-900">Ticket Details</h2>
        </div>

        <!-- Ticket Information -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Ticket Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold">{{ $booking->train->name }}</h3>
                        <p class="text-green-100">Train No: {{ $booking->train->number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Booking Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Booking Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">PNR Number:</span>
                                    <span class="font-bold text-lg">{{ $booking->pnr }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Booking Status:</span>
                                    <span class="font-medium {{ $booking->status === 'confirmed' ? 'text-green-600' : ($booking->status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                @if($booking->seat_number)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Seat Number:</span>
                                    <span class="font-medium">{{ $booking->seat_number }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Booking Date:</span>
                                    <span class="font-medium">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Journey Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Journey Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">From:</span>
                                    <span class="font-medium">{{ $booking->fromStation->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">To:</span>
                                    <span class="font-medium">{{ $booking->toStation->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Journey Date:</span>
                                    <span class="font-medium">{{ $booking->journey_date->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Class:</span>
                                    <span class="font-medium">{{ $booking->class_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Passenger Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Passenger Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-medium">{{ $booking->passenger_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Type:</span>
                                    <span class="font-medium">{{ ucfirst($booking->passenger_type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Mobile:</span>
                                    <span class="font-medium">{{ $booking->mobile }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $booking->email }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Payment Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ticket Fare:</span>
                                    <span class="font-medium">৳{{ number_format($booking->fare, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">VAT:</span>
                                    <span class="font-medium">৳{{ number_format($booking->vat, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service Charge:</span>
                                    <span class="font-medium">৳{{ number_format($booking->service_charge, 2) }}</span>
                                </div>
                                <hr class="my-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total Amount:</span>
                                    <span class="text-green-600">৳{{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                                
                                @if($booking->payment)
                                <div class="mt-4 pt-4 border-t">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Payment Method:</span>
                                        <span class="font-medium">{{ ucfirst($booking->payment->payment_method) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Transaction ID:</span>
                                        <span class="font-medium">{{ $booking->payment->transaction_id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Payment Status:</span>
                                        <span class="font-medium {{ $booking->payment->status === 'completed' ? 'text-green-600' : ($booking->payment->status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ ucfirst($booking->payment->status) }}
                                        </span>
                                    </div>
                                    @if($booking->payment->paid_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Payment Date:</span>
                                        <span class="font-medium">{{ $booking->payment->paid_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-800 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important Notes
                    </h4>
                    <ul class="text-yellow-700 text-sm space-y-1">
                        <li>• Please carry a valid photo ID (NID/Passport) during travel</li>
                        <li>• Arrive at the station at least 30 minutes before departure</li>
                        <li>• This ticket is non-transferable</li>
                        <li>• Cancellation charges may apply as per railway rules</li>
                        @if($booking->status === 'confirmed')
                        <li>• Keep this ticket information for your records</li>
                        @endif
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <button onclick="window.print()" 
                            class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-print mr-2"></i>
                        Print Ticket
                    </button>
                    
                    <button onclick="downloadTicket()" 
                            class="flex-1 bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fas fa-download mr-2"></i>
                        Download PDF
                    </button>
                    
                    <a href="{{ route('ticket.verify') }}" 
                       class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-md font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center">
                        <i class="fas fa-search mr-2"></i>
                        Verify Another
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadTicket() {
    // In a real application, this would generate and download a PDF
    alert('PDF download feature will be implemented with a PDF library like TCPDF or DomPDF');
}

// Print styles
const printStyles = `
    <style>
        @media print {
            body * { visibility: hidden; }
            .ticket-container, .ticket-container * { visibility: visible; }
            .ticket-container { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
`;

document.head.insertAdjacentHTML('beforeend', printStyles);
document.querySelector('.bg-white.rounded-lg.shadow-lg').classList.add('ticket-container');
document.querySelector('.mt-6.flex').classList.add('no-print');
</script>
@endsection
