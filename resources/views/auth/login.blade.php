@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left side image section -->
        <div class="col-md-7 d-none d-md-flex bg-primary p-0">
            <div class="login-banner w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-5">
                <h1 class="display-4 font-weight-bold mb-4">User Management System</h1>
                <p class="lead mb-5">Streamline your workflow with our comprehensive user management solution</p>
                <div class="banner-image">
                    <!-- SVG illustration for user management system -->
                    <svg width="400" height="300" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" fill="none"/>
                        <circle cx="300" cy="150" r="100" fill="rgba(255,255,255,0.2)"/>
                        <circle cx="180" cy="220" r="50" fill="rgba(255,255,255,0.15)"/>
                        <circle cx="420" cy="220" r="50" fill="rgba(255,255,255,0.15)"/>
                        <path d="M200,320 Q300,250 400,320" stroke="rgba(255,255,255,0.5)" stroke-width="8" fill="none"/>
                        <circle cx="300" cy="120" r="30" fill="#ffffff"/>
                        <circle cx="180" cy="210" r="20" fill="#ffffff"/>
                        <circle cx="420" cy="210" r="20" fill="#ffffff"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Right side login form -->
        <div class="col-md-5 d-flex align-items-center justify-content-center">
            <div class="card border-0 shadow-lg mx-auto" style="max-width: 400px; width: 100%;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="font-weight-bold">Welcome Back</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>
                    
                    <form id="loginForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="form-label text-muted font-weight-bold small">EMAIL ADDRESS</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                </div>
                                <input type="email" id="email" class="form-control bg-light border-left-0" placeholder="name@company.com" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label text-muted font-weight-bold small">PASSWORD</label>
                                <a href="#" class="small text-primary">Forgot password?</a>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                </div>
                                <input type="password" id="password" class="form-control bg-light border-left-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberMe">
                                <label class="custom-control-label small text-muted" for="rememberMe">Remember me for 30 days</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-4 mb-3">Sign In</button>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted small mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fonts and Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Bootstrap and Toastr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    .login-banner {
        background-color: #2563eb;
        background-image: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    }
    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
    }
    .text-primary {
        color: #2563eb !important;
    }
    .input-group-text {
        background-color: #f9fafb;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        border-color: #93c5fd;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>

<!-- jQuery, Bootstrap and Toastr scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000"
        };
        
        $("#loginForm").submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Authenticating...');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: "/login",
                method: "POST",
                data: {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.access_token) {
                        localStorage.setItem("access_token", response.access_token);
                        toastr.success("Authentication successful! Redirecting to dashboard...");
                        setTimeout(() => {
                            window.location.href = "/dashboard";
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.error || "Invalid credentials. Please try again.");
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection