<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Code</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff;">
        <div style="text-align: center; padding: 20px;">
            <h1 style="color: #333333; font-size: 24px; margin-bottom: 20px;">
                Security Verification Code
            </h1>
            
            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">
                Please use the following code to verify your account:
            </p>

            <div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <span style="font-size: 32px; font-weight: bold; color: #2563eb; letter-spacing: 5px;">
                    {!! $otp !!}
                </span>
            </div>

            <p style="color: #666666; font-size: 14px; margin-top: 20px;">
                This code will expire in 5 minutes
            </p>
            
            <p style="color: #ff0000; font-size: 14px; margin-top: 20px;">
                Do not share this code with anyone
            </p>
        </div>
    </div>
</body>
</html>
