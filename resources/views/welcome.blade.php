<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .nav-links a:hover {
            background-color: #34495e;
        }
        
        .nav-links a.primary {
            background-color: #3498db;
        }
        
        .nav-links a.primary:hover {
            background-color: #2980b9;
        }
        
        .hero {
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
            color: #7f8c8d;
        }
        
        .features {
            padding: 3rem 0;
            background-color: white;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            background-color: #e3f2fd;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #3498db;
        }
        
        .feature-card h3 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">User Management System</div>
                <div class="nav-links">
                    <a href="#features">Features</a>
                    <a href="#about">About</a>
                    <a href="/login" class="primary">Login</a>
                    <a href="/register">Register</a>
                </div>
            </nav>
        </div>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Welcome to User Management System</h1>
            <p>Streamline your organization with powerful user authentication, role-based access control, and comprehensive user administration tools.</p>
            <a href="/register" class="btn">Get Started</a>
        </div>
    </section>
    
    <section class="features" id="features">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">Key Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Passport-Based Authentication</h3>
                    <p>Implement secure, flexible authentication with Passport.js, supporting local strategy, OAuth, and social logins.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Role & Permission Management</h3>
                    <p>Granular access control with customizable roles and fine-grained permissions for different system functions.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Real-Time Analytics</h3>
                    <p>Monitor system usage, user activity, and business metrics with live dashboards and interactive visualizations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h3>Complete CRUD Operations</h3>
                    <p>Comprehensive Create, Read, Update, and Delete functionality for users, customers, and suppliers in one unified system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>AJAX-Based Data Fetching</h3>
                    <p>Fast, responsive interfaces with asynchronous data loading that eliminates page refreshes and enhances user experience.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Interactive Dashboard</h3>
                    <p>Get insights with real-time statistics on user activity, new signups, and active users.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="about" id="about" style="padding: 3rem 0; text-align: center;">
        <div class="container">
            <h2 style="margin-bottom: 1rem;">Why Choose Our System?</h2>
            <p style="max-width: 800px; margin: 0 auto 2rem auto;">
                Our User Management System is designed with security, scalability, and ease of use in mind. 
                Whether you're managing a small team or a large enterprise, our solution adapts to your needs.
            </p>
            <a href="/contact" class="btn" style="background-color: #2c3e50;">Contact Support</a>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 User Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>