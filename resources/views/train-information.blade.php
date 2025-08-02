@extends('layouts.app')

@section('title', 'Train Information - Bangladesh Railway')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <i class="fas fa-train text-primary me-3" style="font-size: 3rem;"></i>
            <div>
                <h1 class="h3 fw-bold text-primary mb-0">Bangladesh Railway</h1>
                <p class="text-muted small mb-0">নির্ভরযোগ্য • আরামদায়ক • সাশ্রয়ী</p>
            </div>
        </div>
        <h2 class="h2 fw-bold mb-3">Train Information</h2>
        <p class="text-muted">Find detailed information about trains and their schedules</p>
    </div>

    <!-- Search Section -->
    <div class="card mb-5">
        <div class="card-body">
            <h3 class="h5 fw-bold text-primary mb-4"><i class="fas fa-search me-2"></i>Search Train Information</h3>
            
            <div class="row g-3">
                <!-- Search by Train Name/Number -->
                <div class="col-md-4">
                    <label for="train-search" class="form-label fw-semibold">Train Name or Number</label>
                    <input type="text" 
                           id="train-search" 
                           class="form-control"
                           placeholder="e.g., Suborno Express or 701">
                </div>
                
                <!-- Search by Route -->
                <div class="col-md-4">
                    <label for="route-search" class="form-label fw-semibold">Route</label>
                    <select id="route-search" class="form-select">
                        <option value="">Select Route</option>
                        <option value="dhaka-chittagong">Dhaka - Chittagong</option>
                        <option value="dhaka-sylhet">Dhaka - Sylhet</option>
                        <option value="dhaka-rajshahi">Dhaka - Rajshahi</option>
                        <option value="dhaka-rangpur">Dhaka - Rangpur</option>
                        <option value="dhaka-khulna">Dhaka - Khulna</option>
                    </select>
                </div>
                
                <!-- Search Button -->
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" 
                            onclick="searchTrains()"
                            class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Train List -->
    <div class="row g-4" id="train-list">
        @if(isset($trains) && $trains->count() > 0)
            @foreach($trains as $train)
                <div class="col-lg-12 train-card">
                    <div class="card">
                        <!-- Train Header -->
                        <div class="card-header bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="h4 fw-bold mb-1">{{ $train->name }}</h3>
                                    <p class="mb-0 opacity-75">Train No: {{ $train->number }}</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="badge bg-light text-primary fs-6">{{ ucfirst($train->type) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Train Details -->
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Basic Information -->
                                <div class="col-md-4">
                                    <h4 class="h6 fw-bold text-secondary mb-3">Basic Information</h4>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Type:</span>
                                            <span class="fw-medium">{{ ucfirst($train->type) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Status:</span>
                                            <span class="fw-medium {{ $train->is_active ? 'text-success' : 'text-danger' }}">
                                                {{ $train->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Running Days:</span>
                                            <span class="fw-medium">
                                                @if(is_array($train->running_days))
                                                    {{ implode(', ', array_map('ucfirst', $train->running_days)) }}
                                                @else
                                                    Daily
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Available Classes -->
                                <div class="col-md-4">
                                    <h4 class="h6 fw-bold text-secondary mb-3">Available Classes</h4>
                                    <div>
                                        @if(is_array($train->available_classes))
                                            @foreach($train->available_classes as $class)
                                                <span class="badge bg-info text-dark me-1 mb-1">{{ $class }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No class information available</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-md-4">
                                    <h4 class="h6 fw-bold text-secondary mb-3">Actions</h4>
                                    <div class="d-grid gap-2">
                                        <button onclick="viewSchedule({{ $train->id }})" 
                                                class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-clock me-2"></i>View Schedule
                                        </button>
                                        <a href="{{ route('home') }}?train={{ $train->id }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-ticket-alt me-2"></i>Book Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Details (Hidden by default) -->
                            <div id="schedule-{{ $train->id }}" class="mt-4 d-none">
                                <hr>
                                <h4 class="h6 fw-bold text-secondary mb-3">Train Schedule</h4>
                                <div class="bg-light rounded p-3">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-spinner fa-spin fs-4 mb-2"></i>
                                        <p>Loading schedule...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Default Train Information -->
            <div class="col-lg-12 train-card">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="h4 fw-bold mb-1">SUBORNO EXPRESS</h3>
                                <p class="mb-0 opacity-75">Train No: 701</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-light text-primary fs-6">Express</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Basic Information</h4>
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Type:</span>
                                        <span class="fw-medium">Express</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Status:</span>
                                        <span class="fw-medium text-success">Active</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Running Days:</span>
                                        <span class="fw-medium">Daily</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Available Classes</h4>
                                <div>
                                    <span class="badge bg-info text-dark me-1 mb-1">S_CHAIR</span>
                                    <span class="badge bg-info text-dark me-1 mb-1">SNIGDHA</span>
                                    <span class="badge bg-info text-dark me-1 mb-1">AC_S</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Actions</h4>
                                <div class="d-grid gap-2">
                                    <button onclick="alert('Schedule feature coming soon!')" 
                                            class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-clock me-2"></i>View Schedule
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-ticket-alt me-2"></i>Book Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More sample trains -->
            <div class="col-lg-12 train-card">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="h4 fw-bold mb-1">CHATTALA EXPRESS</h3>
                                <p class="mb-0 opacity-75">Train No: 801</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-light text-success fs-6">Express</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Basic Information</h4>
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Route:</span>
                                        <span class="fw-medium">Chittagong - Dhaka</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Status:</span>
                                        <span class="fw-medium text-success">Active</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Running Days:</span>
                                        <span class="fw-medium">Daily</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Available Classes</h4>
                                <div>
                                    <span class="badge bg-info text-dark me-1 mb-1">SNIGDHA</span>
                                    <span class="badge bg-info text-dark me-1 mb-1">AC_S</span>
                                    <span class="badge bg-info text-dark me-1 mb-1">S_CHAIR</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="h6 fw-bold text-secondary mb-3">Actions</h4>
                                <div class="d-grid gap-2">
                                    <button onclick="alert('Schedule feature coming soon!')" 
                                            class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-clock me-2"></i>View Schedule
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-ticket-alt me-2"></i>Book Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- No Results Message (Hidden by default) -->
    <div id="no-results" class="text-center py-5 d-none">
        <i class="fas fa-train text-muted mb-4" style="font-size: 4rem;"></i>
        <h3 class="h4 fw-bold text-muted mb-2">No Trains Found</h3>
        <p class="text-muted">Try adjusting your search criteria</p>
    </div>
</div>

@push('scripts')
<script>
function searchTrains() {
    const trainSearch = document.getElementById('train-search').value.toLowerCase();
    const routeSearch = document.getElementById('route-search').value;
    const trainCards = document.querySelectorAll('.train-card');
    const noResults = document.getElementById('no-results');
    let hasResults = false;

    trainCards.forEach(card => {
        const trainName = card.querySelector('h3').textContent.toLowerCase();
        const trainNumber = card.querySelector('p').textContent.toLowerCase();
        
        let matchesSearch = true;
        let matchesRoute = true;

        if (trainSearch) {
            matchesSearch = trainName.includes(trainSearch) || trainNumber.includes(trainSearch);
        }

        if (routeSearch) {
            // This is a simplified route matching - in real app, you'd check actual routes
            matchesRoute = true; // For demo purposes
        }

        if (matchesSearch && matchesRoute) {
            card.style.display = 'block';
            hasResults = true;
        } else {
            card.style.display = 'none';
        }
    });

    if (hasResults) {
        noResults.classList.add('d-none');
    } else {
        noResults.classList.remove('d-none');
    }
}

function viewSchedule(trainId) {
    const scheduleDiv = document.getElementById(`schedule-${trainId}`);
    
    if (scheduleDiv.classList.contains('d-none')) {
        scheduleDiv.classList.remove('d-none');
        
        // Simulate loading schedule data
        setTimeout(() => {
            scheduleDiv.innerHTML = `
                <hr>
                <h4 class="h6 fw-bold text-secondary mb-3">Train Schedule</h4>
                <div class="bg-light rounded p-3">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Halt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dhaka</td>
                                    <td>--</td>
                                    <td>09:10</td>
                                    <td>0min</td>
                                </tr>
                                <tr>
                                    <td>Bhairab Bazar</td>
                                    <td>09:35</td>
                                    <td>09:36</td>
                                    <td>1min</td>
                                </tr>
                                <tr>
                                    <td>Chittagong</td>
                                    <td>15:45</td>
                                    <td>--</td>
                                    <td>0min</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }, 1000);
    } else {
        scheduleDiv.classList.add('d-none');
    }
}

// Clear search
document.getElementById('train-search').addEventListener('input', function() {
    if (this.value === '') {
        searchTrains();
    }
});

document.getElementById('route-search').addEventListener('change', function() {
    searchTrains();
});
</script>
@endpush
@endsection
