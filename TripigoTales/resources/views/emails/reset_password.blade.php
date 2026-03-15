<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #18a9a1; text-align: center;">Reset Your Password</h2>
        <p>Hello,</p>
        <p>We received a request to reset your password for your <strong>Tripigo Tales</strong> account. Please use the following 6-digit code to complete the reset process:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #18a9a1; padding: 10px 20px; border: 2px dashed #18a9a1; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>
        <p>This code will expire in 10 minutes. If you did not request a password reset, no further action is required.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            &copy; {{ date('Y') }} Tripigo Tales. All rights reserved.
        </p>
    </div>
</body>
</html>
