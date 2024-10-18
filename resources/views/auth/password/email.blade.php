<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-6">
    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Password Reset Request</h1>
        <p class="mb-4">Hello,</p>
        <p class="mb-4">You requested a password reset. Please click the link below to reset your password:</p>
        <a href="{{ url('password/reset', $token) }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200">Reset Password</a>
        <p class="font-bold text-sm mt-4">{{ $token }}</p>
        <p class="mt-4">If you did not request this, please ignore this email.</p>
        <footer class="mt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} Your Company Name. All rights reserved.
        </footer>
    </div>
</body>
</html>
