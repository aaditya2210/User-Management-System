<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .container {
            max-width: 550px;
            padding: 0 30px;
        }
        
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, #4776E6 0%, #8E54E9 100%);
            color: white;
            border-bottom: none;
            padding: 25px 30px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -75px;
            right: -75px;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }
        
        .card-header h3 {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1.75rem;
            position: relative;
            z-index: 1;
        }
        
        .card-body {
            padding: 40px;
            background-color: #ffffff;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        
        .form-control {
            height: 55px;
            font-size: 1.1rem;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            padding: 10px 15px;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .form-control:focus {
            border-color: #8E54E9;
            box-shadow: 0 0 0 3px rgba(142, 84, 233, 0.2);
            background-color: #fff;
        }
        
        .btn-verify {
            background: linear-gradient(135deg, #4776E6 0%, #8E54E9 100%);
            border: none;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(142, 84, 233, 0.3);
            margin-top: 10px;
        }
        
        .btn-verify:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(142, 84, 233, 0.4);
        }
        
        .btn-verify:active {
            transform: translateY(0);
        }
        
        .timer-container {
            margin-top: 20px;
            padding: 15px;
            border-radius: 12px;
            background-color: #f8f9fa;
            text-align: center;
        }
        
        .timer {
            font-size: 1rem;
            color: #495057;
            margin-bottom: 5px;
        }
        
        .timer span {
            font-weight: 600;
            color: #4776E6;
        }
        
        .notification {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: fadeIn 0.5s;
        }
        
        .notification i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .notification-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            border-left: 4px solid #198754;
        }
        
        .notification-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .lock-animation {
            height: 60px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .lock-icon {
            font-size: 35px;
            color: #8E54E9;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
            60% {
                transform: translateY(-7px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h3><i class="fas fa-shield-alt me-2"></i>OTP Verification</h3>
            </div>
            <div class="card-body">
                <!-- Success notification (hidden by default) -->
                <div class="notification notification-success" style="display: none;" id="successNotification">
                    <i class="fas fa-check-circle"></i>
                    <span>OTP verified successfully! Redirecting...</span>
                </div>
                
                <!-- Error notification (hidden by default) -->
                <div class="notification notification-error" style="display: none;" id="errorNotification">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Invalid OTP. Please try again.</span>
                </div>
                
                <div class="lock-animation">
                    <i class="fas fa-lock lock-icon"></i>
                </div>
                
                <form action="{{ route('otp.verify') }}" method="POST" id="otpForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                    <div class="mb-4">
                        <label for="otp" class="form-label">Enter OTP</label>
                        <input type="text" name="otp" id="otp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-verify">
                        <i class="fas fa-check-double me-2"></i>Verify OTP
                    </button>
                </form>
                
                <div class="timer-container mt-4">
                    <div class="timer">
                        Time remaining: <span id="minutes">05</span>:<span id="seconds">00</span>
                    </div>
                    <a href="#" class="text-decoration-none text-primary" id="resendLink" style="display: none;">
                        <i class="fas fa-paper-plane me-1"></i>Resend OTP
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission for validation feedback
            $('#otpForm').on('submit', function(e) {
                // This is just for demo purposes - in production this validation
                // would happen server-side after the form submits
                
                // Simulating a successful verification
                // Uncomment the next line and comment the line after to show success message
                // $('#successNotification').fadeIn();
                // $('#errorNotification').fadeIn();
                
                // Note: In a real implementation, you would remove this setTimeout
                // setTimeout(function() {
                //     $('#successNotification, #errorNotification').fadeOut();
                // }, 3000);
                
                // Comment out this line in production as it prevents the form from submitting
                // e.preventDefault();
            });
            
            // 5-minute countdown timer
            let totalSeconds = 5 * 60; // 5 minutes in seconds
            
            function updateTimer() {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                
                $('#minutes').text(minutes.toString().padStart(2, '0'));
                $('#seconds').text(seconds.toString().padStart(2, '0'));
                
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    $('#resendLink').show();
                } else {
                    totalSeconds--;
                }
            }
            
            // Initial timer update
            updateTimer();
            
            // Start the timer
            const timerInterval = setInterval(updateTimer, 1000);
            
            // Resend OTP functionality
            $('#resendLink').on('click', function(e) {
                e.preventDefault();
                $(this).hide();
                
                // Reset timer
                totalSeconds = 5 * 60;
                updateTimer();
                
                // Restart timer
                clearInterval(timerInterval);
                setInterval(updateTimer, 1000);
                
                // Show a temporary message (optional)
                const resendMessage = $('<div class="notification notification-success"><i class="fas fa-paper-plane"></i><span>A new OTP has been sent.</span></div>');
                resendMessage.insertBefore($('#otpForm'));
                
                setTimeout(function() {
                    resendMessage.fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
            });
        });
    </script>
</body>
</html>