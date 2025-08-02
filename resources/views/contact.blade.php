@extends('layouts.app')

@section('title', 'Contact Us - Bangladesh Railway')

@section('content')
<div class="min-vh-100 bg-light py-4">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-train text-primary me-2" style="font-size: 2rem;"></i>
                <div>
                    <h1 class="h4 fw-bold text-primary mb-0">Bangladesh</h1>
                    <p class="text-muted small mb-0">Railway</p>
                </div>
            </div>
            <h2 class="h3 fw-bold text-dark mb-2">Contact Us</h2>
            <p class="text-muted">Get in touch with us for any queries or support</p>
        </div>

        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-6 mb-4">
                <!-- General Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-bold text-primary mb-3">General Information</h3>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt text-primary mt-1 me-3"></i>
                                <div>
                                    <h4 class="fw-medium mb-1">Address</h4>
                                    <p class="text-muted mb-0">Bangladesh Railway Headquarters<br>
                                    Rail Bhaban, Abdul Ghani Road<br>
                                    Dhaka-1000, Bangladesh</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-phone text-primary mt-1 me-3"></i>
                                <div>
                                    <h4 class="fw-medium mb-1">Phone</h4>
                                    <p class="text-muted mb-0">+880-2-9551234<br>+880-2-9551235</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-envelope text-primary mt-1 me-3"></i>
                                <div>
                                    <h4 class="fw-medium mb-1">Email</h4>
                                    <p class="text-muted mb-0">info@railway.gov.bd<br>support@railway.gov.bd</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Support -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-bold text-primary mb-3">Payment Support</h3>
                        <div>
                            @if(isset($supportNumbers))
                                @foreach($supportNumbers as $method => $number)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-medium text-capitalize">{{ str_replace('_', ' ', $method) }}</span>
                                        <span class="text-muted">{{ $number }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-medium">bKash</span>
                                    <span class="text-muted">16247</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-medium">Nagad</span>
                                    <span class="text-muted">16167</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-medium">Rocket</span>
                                    <span class="text-muted">16216</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-medium">Upay</span>
                                    <span class="text-muted">16268</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-medium">Visa Mastercard</span>
                                    <span class="text-muted">N/A</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="card border-danger shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 fw-bold text-danger mb-3">Emergency Contact</h3>
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle text-warning me-3"></i>
                                <span class="fw-medium">Emergency Helpline: 999</span>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-danger me-3"></i>
                                <span class="fw-medium">Railway Police: 01713-373737</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 fw-bold text-primary mb-4">Send us a Message</h3>
                        
                        <form action="#" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label fw-medium">First Name *</label>
                                    <input type="text" 
                                           id="first_name" 
                                           name="first_name" 
                                           class="form-control"
                                           required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label fw-medium">Last Name *</label>
                                    <input type="text" 
                                           id="last_name" 
                                           name="last_name" 
                                           class="form-control"
                                           required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Email Address *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-medium">Phone Number</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-medium">Subject *</label>
                                <select id="subject" 
                                        name="subject" 
                                        class="form-select"
                                        required>
                                    <option value="">Select Subject</option>
                                    <option value="booking">Booking Issues</option>
                                    <option value="payment">Payment Problems</option>
                                    <option value="refund">Refund Request</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="complaint">Complaint</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-medium">Message *</label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="5"
                                          class="form-control"
                                          placeholder="Please describe your issue or inquiry in detail..."
                                          required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg fw-medium">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-5">
            <h3 class="h4 fw-bold text-center text-dark mb-4">Frequently Asked Questions</h3>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="h6 fw-semibold text-primary mb-2">How can I cancel my ticket?</h4>
                            <p class="text-muted small mb-0">You can cancel your ticket online through your booking history or visit the nearest railway station counter. Cancellation charges may apply based on the time of cancellation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="h6 fw-semibold text-primary mb-2">What payment methods are accepted?</h4>
                            <p class="text-muted small mb-0">We accept bKash, Nagad, Rocket, Upay, Visa, and Mastercard for online payments. Cash payments are accepted at station counters.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="h6 fw-semibold text-primary mb-2">How early should I arrive at the station?</h4>
                            <p class="text-muted small mb-0">We recommend arriving at least 30 minutes before departure for intercity trains and 15 minutes for local trains.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="h6 fw-semibold text-primary mb-2">Can I change my travel date?</h4>
                            <p class="text-muted small mb-0">Yes, you can change your travel date subject to availability and applicable charges. Visit the station counter or contact our support team.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
