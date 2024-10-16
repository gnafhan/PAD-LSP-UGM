<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
    </style>
</head>
<body>
    <p>Hello,</p>
    <p>You requested a password reset. Please click the link below to reset your password:</p>
    <a href="{{ url('password/reset', $token) }}">Reset Password</a>
    <p><strong>{{ $token }}</strong></p>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
