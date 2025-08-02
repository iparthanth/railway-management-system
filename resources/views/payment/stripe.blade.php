@extends('layouts.app')

@section('title', 'Pay with Stripe - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">Complete Your Payment</h2>
            <p class="text-gray-600">Amount to pay: {{ number_format($payment->amount, 2) }} BDT</p>
        </div>

        <form id="payment-form" class="space-y-4">
            <div id="payment-element" class="p-4 border rounded-md">
                <!-- Stripe Elements will be inserted here -->
            </div>

            <button id="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay Now</span>
            </button>

            <div id="payment-message" class="hidden text-center mt-4"></div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('stripe.key') }}');
    const clientSecret = '{{ $clientSecret }}';

    const elements = stripe.elements({
        clientSecret: clientSecret,
        appearance: {
            theme: 'stripe',
        },
    });

    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const spinner = document.getElementById('spinner');
    const messageDiv = document.getElementById('payment-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        setLoading(true);

        const {error} = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route('payment.callback') }}',
            },
        });

        if (error) {
            showMessage(error.message);
        }

        setLoading(false);
    });

    function setLoading(isLoading) {
        submitButton.disabled = isLoading;
        spinner.classList.toggle('hidden', !isLoading);
        document.getElementById('button-text').classList.toggle('hidden', isLoading);
    }

    function showMessage(messageText) {
        messageDiv.classList.remove('hidden');
        messageDiv.textContent = messageText;
        setTimeout(() => {
            messageDiv.classList.add('hidden');
            messageText.textContent = '';
        }, 4000);
    }
</script>

<style>
    .spinner {
        width: 20px;
        height: 20px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush
@endsection
