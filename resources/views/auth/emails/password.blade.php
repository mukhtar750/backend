<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Notification</title>
</head>
<body>
    <h1>Reset Password Notification</h1>
    
    <p>You are receiving this email because we received a password reset request for your account.</p>
    
    <p><a href="{{ $resetUrl }}" style="background-color: #3490dc; color: white; padding: 10px 15px; text-decoration: none; border-radius: 3px;">Reset Password</a></p>
    
    <p>This password reset link will expire in 60 minutes.</p>
    
    <p>If you did not request a password reset, no further action is required.</p>
    
    <p>Regards,<br>
    {{ config('app.name') }}</p>
    
    <hr>
    
    <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
</body>
</html>