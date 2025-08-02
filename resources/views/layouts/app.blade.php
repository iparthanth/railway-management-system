<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bangladesh Railway - Online Ticket Booking')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #006A4E;
            --secondary-color: #F42A41;
            --accent-color: #FFB200;
            --text-dark: #2C3E50;
            --text-light: #7F8C8D;
            --bg-light: #F8F9FA;
            --success-color: #27AE60;
            --warning-color: #F39C12;
            --danger-color: #E74C3C;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #004d3a;
            border-color: #004d3a;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), #004d3a);
            color: white;
            padding: 80px 0;
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 106, 78, 0.25);
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .footer {
            background-color: var(--text-dark);
            color: white;
            padding: 40px 0;
        }
        
        .loading {
            display: none;
        }
        
        .loading.active {
            display: block;
        }
        
        .seat {
            width: 40px;
            height: 40px;
            margin: 2px;
            border: 2px solid #ddd;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 600;
        }
        
        .seat.available {
            background-color: #E8F5E8;
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .seat.booked {
            background-color: #FFEBEE;
            border-color: var(--danger-color);
            color: var(--danger-color);
            cursor: not-allowed;
        }
        
        .seat.selected {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .train-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover,
        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: #f8f9fa;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-train me-2"></i>Bangladesh Railway
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('train.information') ? 'active' : '' }}" href="{{ route('train.information') }}">
                            <i class="fas fa-info-circle me-1"></i>Train Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ticket.verify') ? 'active' : '' }}" href="{{ route('ticket.verify') }}">
                            <i class="fas fa-ticket-alt me-1"></i>Verify Ticket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('purchase.history') }}"><i class="fas fa-history me-2"></i>Purchase History</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                <div class="container">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                <div class="container">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3"><i class="fas fa-train me-2"></i>Bangladesh Railway</h5>
                    <p class="text-light">The official online ticket booking platform for Bangladesh Railway. Book your train tickets easily and securely.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ route('train.information') }}" class="text-light text-decoration-none">Trains</a></li>
                        <li><a href="{{ route('ticket.verify') }}" class="text-light text-decoration-none">Verify Ticket</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6 mb-4">
                    <h6 class="mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><span class="text-light"><i class="fas fa-phone me-2"></i>+88 01700-000000</span></li>
                        <li><span class="text-light"><i class="fas fa-envelope me-2"></i>support@railway.gov.bd</span></li>
                        <li><span class="text-light"><i class="fas fa-clock me-2"></i>24/7 Support</span></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light">© {{ date('Y') }} Bangladesh Railway. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Loading states
        function showLoading(element) {
            element.prop('disabled', true);
            element.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...');
        }
        
        function hideLoading(element, originalText) {
            element.prop('disabled', false);
            element.html(originalText);
        }
    </script>
    
    @stack('scripts')
</body>
</html>
