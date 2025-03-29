@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="login-container">
        <div class="login-content">
            <div class="login-grid">
                <!-- Left Side: Creative Visual Section -->
                <div class="login-visual-section">
                    <div class="visual-overlay"></div>
                    <div class="visual-content">
                        <div class="logo-container">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="brand-logo">
                                <circle cx="50" cy="50" r="45" fill="#2563eb"/>
                                <path d="M35 50 L50 35 L65 50 L50 65 Z" fill="white"/>
                                <circle cx="50" cy="50" r="10" fill="white" opacity="0.5"/>
                            </svg>
                            <h2 class="brand-name">UserHub</h2>
                        </div>
                        <div class="tagline-container">
                            <h3>Empowering Your Digital Workspace</h3>
                            <p>Seamless authentication. Advanced security. Intelligent management.</p>
                        </div>
                        <div class="visual-features">
                            <div class="feature">
                                <i class="fas fa-shield-alt"></i>
                                <span>Advanced Security</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-chart-line"></i>
                                <span>Performance Tracking</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-user-cog"></i>
                                <span>User Management</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Login Form -->
                <div class="login-form-section">
                    <form id="loginForm" class="login-form" novalidate>
                        @csrf
                        <div class="form-header">
                            <h2>Welcome Back</h2>
                            <p>Sign in to continue to UserHub</p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required 
                                    placeholder="Enter your email"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                >
                                <div class="error-message" id="email-error"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required 
                                    placeholder="Enter your password"
                                    minlength="8"
                                >
                                <span class="password-toggle">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                                <div class="error-message" id="password-error"></div>
                            </div>
                            <div class="form-extras">
                                <div class="remember-me">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">Remember me</label>
                                </div>
                                <a href="#" class="forgot-password">Forgot Password?</a>
                            </div>
                        </div>

                        <button type="submit" class="login-button" id="login-button">
                            Sign In
                            <div class="button-overlay"></div>
                        </button>

                        {{-- <div class="social-login">
                            <div class="divider">
                                <span>or continue with</span>
                            </div>
                            <div class="social-buttons">
                                <button type="button" class="social-btn google">
                                    <i class="fab fa-google"></i>
                                </button>
                                <button type="button" class="social-btn microsoft">
                                    <i class="fab fa-microsoft"></i>
                                </button>
                                <button type="button" class="social-btn apple">
                                    <i class="fab fa-apple"></i>
                                </button>
                            </div>
                        </div> --}}

                        <div class="signup-link">
                            Don't have an account? 
                            <a href="{{ route('register') }}">Create Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --secondary-color: #3b82f6;
        --text-color: #1f2937;
        --text-muted: #6b7280;
        --background-color: #f9fafb;
        --card-background: #ffffff;
        --border-color: #e5e7eb;
        --input-focus: rgba(37, 99, 235, 0.1);
        --error-color: #ef4444;
        --success-color: #10b981;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background-color: var(--background-color);
    }

    .login-container {
        width: 1200px;
        max-width: 95vw;
        background-color: var(--card-background);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .login-container:hover {
        transform: translateY(-5px);
    }

    .login-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 700px;
    }

    .login-visual-section {
        position: relative;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--card-background);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        overflow: hidden;
    }

    .visual-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.1);
        pointer-events: none;
        background-image: 
            radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 12%),
            radial-gradient(circle at 70% 60%, rgba(255, 255, 255, 0.08) 0%, transparent 15%),
            radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 10%);
    }

    .visual-content {
        position: relative;
        z-index: 1;
        text-align: center;
        width: 100%;
    }

    .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 40px;
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .brand-logo {
        width: 100px;
        height: 100px;
        margin-bottom: 15px;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .brand-name {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .tagline-container {
        margin-bottom: 50px;
        animation: fadeIn 0.8s ease 0.2s forwards;
        opacity: 0;
    }

    .tagline-container h3 {
        font-size: 28px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .tagline-container p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 400px;
        margin: 0 auto 30px;
    }

    .visual-features {
        display: flex;
        justify-content: center;
        gap: 40px;
        animation: fadeIn 0.8s ease 0.4s forwards;
        opacity: 0;
    }

    .feature {
        display: flex;
        flex-direction: column;
        align-items: center;
        opacity: 0.9;
        transition: var(--transition);
    }
    
    .feature:hover {
        opacity: 1;
        transform: translateY(-5px);
    }

    .feature i {
        font-size: 32px;
        margin-bottom: 12px;
        background: rgba(255, 255, 255, 0.15);
        height: 60px;
        width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        backdrop-filter: blur(5px);
    }

    .feature span {
        font-weight: 500;
    }

    .login-form-section {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .login-form {
        width: 100%;
        max-width: 400px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .form-header h2 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 700;
        color: var(--text-color);
    }

    .form-header p {
        color: var(--text-muted);
        font-size: 16px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    label {
        display: block;
        margin-bottom: -15px;
        font-weight: 500;
        font-size: 14px;
        color: var(--text-color);
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: relative;
        left: 12px;
        top: -165%;
        transform: translateY(258%);
        color: var(--text-muted);
        transition: var(--transition);
    }

    .input-wrapper input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 16px;
        transition: var(--transition);
        background-color: #f9fafb;
    }

    .input-wrapper input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--input-focus);
        background-color: var(--card-background);
    }

    .input-wrapper input:focus + i {
        color: var(--primary-color);
    }

    .input-wrapper input.error {
        border-color: var(--error-color);
        background-color: rgba(239, 68, 68, 0.05);
    }

    .error-message {
        color: var(--error-color);
        font-size: 12px;
        margin-top: 6px;
        min-height: 18px;
        font-weight: 500;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-muted);
        transition: var(--transition);
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .form-extras {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .remember-me input {
        margin-right: 8px;
        accent-color: var(--primary-color);
    }

    .remember-me label {
        margin-bottom: 0;
        font-size: 14px;
        color: var(--text-muted);
        cursor: pointer;
    }

    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .login-button {
        width: 100%;
        padding: 15px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        margin-top: 10px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
    }

    .login-button:hover {
        background-color: var(--primary-hover);
        box-shadow: 0 6px 10px rgba(37, 99, 235, 0.3);
    }

    .button-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.6s ease;
    }

    .login-button:hover .button-overlay {
        transform: scaleX(1);
        transform-origin: left;
    }

    .social-login {
        margin-top: 35px;
        text-align: center;
    }

    .divider {
        position: relative;
        text-align: center;
        margin-bottom: 20px;
    }

    .divider span {
        background: var(--card-background);
        padding: 0 15px;
        position: relative;
        z-index: 1;
        color: var(--text-muted);
        font-size: 14px;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--border-color);
        z-index: 0;
    }

    .social-buttons {
        display: flex;
        justify-content: center;
        gap: 16px;
    }

    .social-btn {
        width: 54px;
        height: 54px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: #f9fafb;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        font-size: 20px;
    }

    .social-btn:hover {
        background: #f3f4f6;
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .social-btn.google:hover { color: #DB4437; }
    .social-btn.microsoft:hover { color: #0078D4; }
    .social-btn.apple:hover { color: #000000; }

    .signup-link {
        text-align: center;
        margin-top: 25px;
        color: var(--text-muted);
        font-size: 15px;
    }

    .signup-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    /* Toastr override styles for better integration */
    #toast-container > div {
        opacity: 1;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: var(--radius-md);
        padding: 15px 15px 15px 50px;
        font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
    }

    #toast-container > div:hover {
        box-shadow: 0 15px 20px -3px rgba(0, 0, 0, 0.1), 0 8px 8px -2px rgba(0, 0, 0, 0.05);
    }

    .toast-success {
        background-color: var(--success-color) !important;
    }

    .toast-error {
        background-color: var(--error-color) !important;
    }

    .toast-info {
        background-color: var(--primary-color) !important;
    }

    .toast-warning {
        background-color: #f59e0b !important;
    }

    /* Responsive styles */
    @media (max-width: 991px) {
        .login-grid {
            grid-template-columns: 1fr;
        }
        
        .login-visual-section {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .login-form-section {
            padding: 30px 20px;
        }
        
        .form-header h2 {
            font-size: 24px;
        }
        
        .social-buttons {
            gap: 10px;
        }
        
        .social-btn {
            width: 48px;
            height: 48px;
        }
    }
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
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
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Initialize toastr for testing
        // Comment out in production
        // toastr.info('Welcome back! Please login to continue.');

        // Password toggle
        $('.password-toggle').on('click', function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        // Form validation
        function validateEmail(email) {
            const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return regex.test(email);
        }

        function validatePassword(password) {
            return password.length >= 8;
        }

        function validateForm() {
            let isValid = true;
            const email = $('#email').val();
            const password = $('#password').val();
            
            // Reset error states
            $('#email').removeClass('error');
            $('#password').removeClass('error');
            $('#email-error').text('');
            $('#password-error').text('');
            
            // Email validation
            if (!email) {
                $('#email').addClass('error');
                $('#email-error').text('Email is required');
                isValid = false;
            } else if (!validateEmail(email)) {
                $('#email').addClass('error');
                $('#email-error').text('Please enter a valid email address');
                isValid = false;
            }
            
            // Password validation
            if (!password) {
                $('#password').addClass('error');
                $('#password-error').text('Password is required');
                isValid = false;
            } else if (!validatePassword(password)) {
                $('#password').addClass('error');
                $('#password-error').text('Password must be at least 8 characters');
                isValid = false;
            }
            
            return isValid;
        }

        // Form submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                toastr.warning('Please correct the errors in the form.');
                return;
            }
            
            const email = $('#email').val();
            const password = $('#password').val();
            const rememberMe = $('#remember').is(':checked');
            
            // Show loading state
            const submitBtn = $('#login-button');
            const originalText = submitBtn.text();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Authenticating...');
            submitBtn.prop('disabled', true);
            
            // AJAX request
            $.ajax({
                url: "/login",
                method: "POST",
                data: {
                    email: email,
                    password: password,
                    remember: rememberMe ? 1 : 0,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.access_token) {
                        // Store token in localStorage
                        localStorage.setItem("access_token", response.access_token);
                        
                        // Show success message
                        toastr.success("Authentication successful! Redirecting to dashboard...");
                        
                        // Redirect after a short delay
                        setTimeout(function() {
                            window.location.href = "/dashboard";
                        }, 1500);
                    } else {
                        // Fallback success message if no token
                        toastr.success("Login successful! Redirecting...");
                        setTimeout(function() {
                            window.location.href = "/dashboard";
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    // Reset button state
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                    
                    // Show error message
                    if (xhr.status === 401) {
                        toastr.error("Invalid credentials. Please try again.");
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        toastr.error(xhr.responseJSON.error);
                    } else {
                        toastr.error("An error occurred. Please try again later.");
                    }
                }
            });
        });

        // Social login buttons (for demo only)
        $('.social-btn').on('click', function() {
            const provider = $(this).hasClass('google') ? 'Google' : 
                            ($(this).hasClass('microsoft') ? 'Microsoft' : 'Apple');
            
            toastr.info(`${provider} login will be integrated soon.`);
        });

        // Forgot password link
        $('.forgot-password').on('click', function(e) {
            e.preventDefault();
            toastr.info("Password reset functionality will be available soon.");
        });
    });
</script>
@endsection