<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #18a9a1; text-align: center;">Email Verification</h2>
        <p>Hello,</p>
        <p>Thank you for registering with <strong>Tripigo Tales</strong>. To complete your registration, please use the following 6-digit verification code:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #18a9a1; padding: 10px 20px; border: 2px dashed #18a9a1; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>
        <p>This code will expire in 10 minutes. If you did not request this, please ignore this email.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            &copy; {{ date('Y') }} Tripigo Tales. All rights reserved.
        </p>
    </div>
</body>
</html>
