<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3f37c9;
            --secondary-color: #4cc9f0;
            --text-dark: #212b36;
            --text-light: #637381;
            --background-light: #f9fafb;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: var(--background-light);
            color: var(--text-dark);
            overflow: hidden;
        }
        
        .login-container {
            min-height: 100vh;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }
        
        /* Left Brand Column */
        .brand-column {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            position: relative;
            overflow: hidden;
            padding: 0;
        }
        
        .brand-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.7;
        }
        
        .brand-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100%;
            padding: 3rem;
        }
        
        .brand-logo {
            margin-bottom: 2rem;
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        
        .brand-logo i {
            font-size: 40px;
            color: var(--primary-color);
        }
        
        .brand-illustration {
            max-width: 80%;
            margin: 1.5rem 0;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1));
        }
        
        .brand-text h1 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .brand-text p {
            font-size: 1.1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.85);
            max-width: 80%;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* Right Form Column */
        .form-column {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem;
        }
        
        .login-form {
            width: 100%;
            max-width: 480px;
            padding: 1.5rem 0;
        }
        
        .login-header {
            margin-bottom: 2.5rem;
        }
        
        .login-header h2 {
            font-weight: 700;
            font-size: 2rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }
        
        .login-header p {
            color: var(--text-light);
            font-size: 1rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .input-group {
            background-color: #f4f6f8;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        
        .input-group:focus-within {
            background-color: #fff;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }
        
        .input-group-text {
            background-color: transparent;
            border: none;
            color: var(--text-light);
            padding-left: 1.25rem;
        }
        
        .form-control {
            background-color: transparent;
            border: none;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            color: var(--text-dark);
        }
        
        .form-control::placeholder {
            color: #b0b7c3;
        }
        
        .form-control:focus {
            box-shadow: none;
            background-color: transparent;
        }
        
        .password-toggle {
            border: none;
            background-color: transparent;
            cursor: pointer;
            color: var(--text-light);
            padding-right: 1.25rem;
        }
        
        .form-check-input {
            border-color: #d9dee3;
            width: 1.1rem;
            height: 1.1rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .forgot-link {
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            border: none;
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.3);
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
        }
        
        .create-account {
            text-align: center;
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        .create-link {
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .create-link:hover {
            color: var(--primary-dark);
        }
        
        /* Bottom version info */
        .version-info {
            position: absolute;
            bottom: 0.75rem;
            right: 1rem;
            font-size: 0.75rem;
            color: var(--text-light);
            opacity: 0.7;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .brand-column {
                display: none;
            }
            .form-column {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0 login-container">
            <!-- Left Column with Illustration -->
            <div class="col-lg-6 brand-column">
                <div class="brand-overlay"></div>
                <div class="brand-content">
                    <div class="brand-logo">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Enterprise Manager</h1>
                        <p>Streamline operations, enhance productivity, and drive business growth with our comprehensive management solution.</p>
                    </div>
                    <div class="brand-illustration">
                        <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                            <!-- Main Dashboard Panel -->
                            <rect x="50" y="50" width="400" height="300" rx="16" fill="white" fill-opacity="0.95" filter="drop-shadow(0px 8px 24px rgba(0, 0, 0, 0.15))"/>
                            
                            <!-- Top Navigation Bar -->
                            <rect x="50" y="50" width="400" height="50" rx="16" fill="#e6efff"/>
                            <circle cx="85" cy="75" r="15" fill="#4361ee"/>
                            <rect x="120" y="65" width="80" height="20" rx="4" fill="#d1e0ff"/>
                            <rect x="220" y="65" width="80" height="20" rx="4" fill="#d1e0ff"/>
                            <rect x="320" y="65" width="80" height="20" rx="4" fill="#d1e0ff"/>
                            
                            <!-- Left Sidebar -->
                            <rect x="50" y="100" width="80" height="250" fill="#f5f8ff"/>
                            <rect x="65" y="120" width="50" height="10" rx="2" fill="#d1e0ff"/>
                            <rect x="65" y="140" width="50" height="10" rx="2" fill="#d1e0ff"/>
                            <rect x="65" y="160" width="50" height="10" rx="2" fill="#d1e0ff"/>
                            <rect x="65" y="180" width="50" height="10" rx="2" fill="#d1e0ff"/>
                            <rect x="65" y="200" width="50" height="10" rx="2" fill="#d1e0ff"/>
                            <rect x="65" y="300" width="50" height="30" rx="4" fill="#4361ee"/>
                            
                            <!-- Main Content Area -->
                            <!-- Header Stats -->
                            <rect x="150" y="110" width="120" height="70" rx="8" fill="#e6efff"/>
                            <rect x="165" y="125" width="70" height="12" rx="2" fill="#d1e0ff"/>
                            <rect x="165" y="145" width="90" height="20" rx="4" fill="#4361ee"/>
                            
                            <rect x="285" y="110" width="120" height="70" rx="8" fill="#e6efff"/>
                            <rect x="300" y="125" width="70" height="12" rx="2" fill="#d1e0ff"/>
                            <rect x="300" y="145" width="90" height="20" rx="4" fill="#4361ee"/>
                            
                            <!-- Chart Area -->
                            <rect x="150" y="190" width="255" height="140" rx="8" fill="#f5f8ff"/>
                            
                            <!-- Line Graph -->
                            <polyline points="165,280 190,260 215,270 240,230 265,245 290,225 315,215 340,240 365,210 390,220" 
                                    stroke="#4361ee" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            
                            <!-- Chart Points -->
                            <circle cx="165" cy="280" r="4" fill="#4361ee"/>
                            <circle cx="190" cy="260" r="4" fill="#4361ee"/>
                            <circle cx="215" cy="270" r="4" fill="#4361ee"/>
                            <circle cx="240" cy="230" r="4" fill="#4361ee"/>
                            <circle cx="265" cy="245" r="4" fill="#4361ee"/>
                            <circle cx="290" cy="225" r="4" fill="#4361ee"/>
                            <circle cx="315" cy="215" r="4" fill="#4361ee"/>
                            <circle cx="340" cy="240" r="4" fill="#4361ee"/>
                            <circle cx="365" cy="210" r="4" fill="#4361ee"/>
                            <circle cx="390" cy="220" r="4" fill="#4361ee"/>
                            
                            <!-- Chart Labels -->
                            <rect x="165" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="190" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="215" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="240" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="265" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="290" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="315" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="340" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="365" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="390" y="295" width="15" height="5" rx="1" fill="#d1e0ff"/>
                            
                            <!-- Y-axis Labels -->
                            <rect x="150" y="220" width="10" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="150" y="250" width="10" height="5" rx="1" fill="#d1e0ff"/>
                            <rect x="150" y="280" width="10" height="5" rx="1" fill="#d1e0ff"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Right Column with Login Form -->
            <div class="col-lg-6 form-column">
                <div class="login-form">
                    <div class="login-header">
                        <h2>Welcome Back</h2>
                        <p>Enter your credentials to access your account</p>
                    </div>
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="far fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="forgot-link text-decoration-none">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-4">Sign In</button>
                        <p class="create-account">
                            Don't have an account? <a href="#" class="create-link text-decoration-none">Request Access</a>
                        </p>
                    </form>
                </div>
                <div class="version-info">v2.7.3</div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>