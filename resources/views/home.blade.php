@extends('layouts.app')

@section('title', 'Bangladesh Railway - Online Train Ticket Booking')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-lg-12">
                <div class="mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-circle mb-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-train fa-3x text-white"></i>
                    </div>
                    <h1 class="display-3 fw-bold text-white mb-4">
                        <span class="text-warning">Bangladesh</span><br>
                        <span class="text-white">Railway</span>
                    </h1>
                    <p class="lead text-white-50 mb-5">
                        Book your train tickets online easily and securely. Travel across Bangladesh with comfort and convenience.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="py-5" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">
                            <i class="fas fa-search text-primary me-2"></i>
                            Search Trains
                        </h3>
                        
                        <form id="searchForm" action="{{ route('search.trains') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <!-- From Station -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt text-success me-1"></i>
                                        From
                                    </label>
                                    <select name="from_station" id="fromStation" class="form-select form-select-lg" required>
                                        <option value="">Select departure</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- To Station -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        To
                                    </label>
                                    <select name="to_station" id="toStation" class="form-select form-select-lg" required>
                                        <option value="">Select destination</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Journey Date -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        Journey Date
                                    </label>
                                    <input type="date" name="journey_date" id="journeyDate" class="form-control form-control-lg" 
                                           min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+30 days')) }}" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>

                                <!-- Train Class -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-chair text-warning me-1"></i>
                                        Class
                                    </label>
                                    <select name="class" id="trainClass" class="form-select form-select-lg">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}">{{ str_replace('_', '-', $class) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-search me-2"></i>
                                    Search Trains
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                <p class="lead text-muted">Book your train tickets in 3 simple steps</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-search fa-2x text-primary"></i>
                        </div>
                        <h5 class="card-title">Search</h5>
                        <p class="card-text text-muted">Choose your origin, destination, journey dates and search for trains</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <h5 class="card-title">Select</h5>
                        <p class="card-text text-muted">Select your desired trip and choose your seats</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-credit-card fa-2x text-warning"></i>
                        </div>
                        <h5 class="card-title">Pay</h5>
                        <p class="card-text text-muted">Pay for the tickets via bKash / Credit Card or MFS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Train Classes Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="display-6 fw-bold text-center mb-5">Train Classes & Seat Types</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Seat Type</th>
                                <th scope="col">Description</th>
                                <th scope="col">Features</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>AC-B (AC Berth)</strong></td>
                                <td>AC cabin berth (nighttime)</td>
                                <td><span class="badge bg-success">Air Conditioned</span> <span class="badge bg-info">Berth</span></td>
                            </tr>
                            <tr>
                                <td><strong>AC-S (AC Seat)</strong></td>
                                <td>AC cabin seat (daytime)</td>
                                <td><span class="badge bg-success">Air Conditioned</span> <span class="badge bg-primary">Seat</span></td>
                            </tr>
                            <tr>
                                <td><strong>Snigdha</strong></td>
                                <td>AC chair</td>
                                <td><span class="badge bg-success">Air Conditioned</span> <span class="badge bg-warning">Chair</span></td>
                            </tr>
                            <tr>
                                <td><strong>F-Berth (First Class Berth)</strong></td>
                                <td>Non-AC cabin berth (nighttime)</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-info">Berth</span></td>
                            </tr>
                            <tr>
                                <td><strong>F-Seat (First Class Seat)</strong></td>
                                <td>Non-AC cabin seat (daytime)</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-primary">Seat</span></td>
                            </tr>
                            <tr>
                                <td><strong>F-Chair (First Class Chair)</strong></td>
                                <td>Non-AC first-class chair</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-warning">Chair</span></td>
                            </tr>
                            <tr>
                                <td><strong>S-Chair (Shovan Chair)</strong></td>
                                <td>Non-AC chair</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-warning">Chair</span></td>
                            </tr>
                            <tr>
                                <td><strong>Shovan</strong></td>
                                <td>Non-AC flat bench seat</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-light text-dark">Bench</span></td>
                            </tr>
                            <tr>
                                <td><strong>Shulov</strong></td>
                                <td>Non-AC wooden bench seat</td>
                                <td><span class="badge bg-secondary">Non-AC</span> <span class="badge bg-light text-dark">Bench</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instructions Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="display-6 fw-bold text-center mb-5">Instructions to Purchase Tickets</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">1</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>Only one trip for the tickets using financial services, Bkash, Rocket, Nagad, Upay or credit card. Other payment options are not available.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">2</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>You can only pay for the tickets using financial services, Bkash, Rocket, Nagad, Upay or credit card. Other payment options are not available.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">3</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>In case of payment or transaction failure, the deducted amount would be refunded to your bank or MFS account within 7 working days.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">4</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>If you have lost your ticket and want to collect your ticket from the purchase history of your account, you can login.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">5</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>Download the official Rail Sheba app published by Bangladesh Railway from Google Play Store.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-3">6</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p>You can purchase tickets from the counter as well. But you cannot get refund from online if you purchase from the counter.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@guest
<!-- Call to Action Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="display-6 fw-bold mb-4">Ready to Book Your Journey?</h2>
                <p class="lead mb-4">Join millions of satisfied travelers who book with us</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-user-plus me-2"></i>Register Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

@push('scripts')
<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    const fromStation = document.getElementById('fromStation').value;
    const toStation = document.getElementById('toStation').value;
    
    if (fromStation === toStation && fromStation !== '') {
        e.preventDefault();
        alert('From and To stations cannot be the same.');
        return false;
    }
});

// Station swap functionality
function addStationSwap() {
    const swapBtn = document.createElement('button');
    swapBtn.type = 'button';
    swapBtn.className = 'btn btn-outline-secondary btn-sm position-absolute';
    swapBtn.style.cssText = 'top: 50%; right: -20px; transform: translateY(-50%); z-index: 10;';
    swapBtn.innerHTML = '<i class="fas fa-exchange-alt"></i>';
    swapBtn.title = 'Swap stations';
    
    swapBtn.addEventListener('click', function() {
        const fromSelect = document.getElementById('fromStation');
        const toSelect = document.getElementById('toStation');
        
        const tempValue = fromSelect.value;
        fromSelect.value = toSelect.value;
        toSelect.value = tempValue;
    });
    
    const fromCol = document.querySelector('#fromStation').closest('.col-lg-3');
    fromCol.style.position = 'relative';
    fromCol.appendChild(swapBtn);
}

// Add swap button after page loads
document.addEventListener('DOMContentLoaded', addStationSwap);
</script>
@endpush
@endsection
