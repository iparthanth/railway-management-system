@extends('layouts.app')

@section('title', 'Verify Ticket - Bangladesh Railway')

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
                            <h1 class="h4 fw-bold text-primary mb-0">Bangladesh</h1>
                            <p class="text-muted small mb-0">Railway</p>
                        </div>
                    </div>
                    <h2 class="h3 fw-bold text-dark mb-2">Verify Ticket</h2>
                    <p class="text-muted">Enter your ticket details to verify your booking</p>
                </div>

                <!-- Verification Form -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('ticket.check') }}">
                            @csrf
                            
                            <!-- Ticket Type Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Ticket Type</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ticket_type" id="online" value="online" checked>
                                            <label class="form-check-label w-100" for="online">
                                                <div class="card h-100 ticket-option border-primary">
                                                    <div class="card-body text-center py-3">
                                                        <i class="fas fa-mobile-alt text-primary fs-2 mb-2"></i>
                                                        <h6 class="card-title mb-1">Online Ticket</h6>
                                                        <p class="card-text small text-muted mb-0">Purchased online</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ticket_type" id="counter" value="counter">
                                            <label class="form-check-label w-100" for="counter">
                                                <div class="card h-100 ticket-option">
                                                    <div class="card-body text-center py-3">
                                                        <i class="fas fa-ticket-alt text-muted fs-2 mb-2"></i>
                                                        <h6 class="card-title mb-1">Counter Ticket</h6>
                                                        <p class="card-text small text-muted mb-0">Purchased at station</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- PNR Number -->
                        <div class="mb-4">
                            <label for="pnr" class="form-label fw-semibold">
                                PNR Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="pnr" 
                                   name="pnr" 
                                   value="{{ old('pnr') }}"
                                   placeholder="Enter your PNR number (e.g., BD1234567890)"
                                   class="form-control @error('pnr') is-invalid @enderror"
                                   required>
                            @error('pnr')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mobile Number (for online tickets) -->
                        <div class="mb-4" id="mobile-field">
                            <label for="mobile" class="form-label fw-semibold">
                                Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="mobile" 
                                   name="mobile" 
                                   value="{{ old('mobile') }}"
                                   placeholder="Enter mobile number used for booking"
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   required>
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Required for online tickets only</div>
                        </div>

                            <!-- Verify Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg fw-medium">
                                    <i class="fas fa-search me-2"></i>Verify Ticket
                                </button>
                            </div>
                        </form>

                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <div class="d-flex">
                                    <i class="fas fa-exclamation-circle me-3 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading">Please correct the following errors:</h6>
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Information Section -->
                <div class="card mt-4 border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>How to Verify Your Ticket
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="mb-2">Select your ticket type (Online or Counter)</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-2">Enter your PNR number (found on your ticket)</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-2">For online tickets, enter the mobile number used during booking</p>
                        </div>
                        <div class="mb-0">
                            <p class="mb-0">Click "Verify Ticket" to view your booking details</p>
                        </div>
                    </div>
                </div>

                <!-- Sample PNR Format -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Sample PNR Format:</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="fw-medium me-2">Online Ticket:</span>
                            <code class="bg-light px-2 py-1 rounded text-primary">BD1234567890</code>
                        </div>
                        <div class="mb-0">
                            <span class="fw-medium me-2">Counter Ticket:</span>
                            <code class="bg-light px-2 py-1 rounded text-success">BD0987654321</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.ticket-option {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.ticket-option:hover {
    border-color: var(--bs-primary);
    transform: translateY(-2px);
}

.form-check-input:checked ~ .form-check-label .ticket-option {
    border-color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    transform: translateY(-2px);
}

.form-check-input:checked ~ .form-check-label .ticket-option i {
    color: var(--bs-primary) !important;
}

.form-check-input:checked ~ .form-check-label .ticket-option .card-title {
    color: var(--bs-primary);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketTypeRadios = document.querySelectorAll('input[name="ticket_type"]');
    const mobileField = document.getElementById('mobile-field');
    const mobileInput = document.getElementById('mobile');
    
    function toggleMobileField() {
        const selectedType = document.querySelector('input[name="ticket_type"]:checked').value;
        
        if (selectedType === 'online') {
            mobileField.style.display = 'block';
            mobileInput.required = true;
        } else {
            mobileField.style.display = 'none';
            mobileInput.required = false;
            mobileInput.value = '';
        }
    }
    
    ticketTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleMobileField);
    });
    
    // Initialize
    toggleMobileField();
});
</script>
@endpush
@endsection
