<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/bg.jpg');">

    <!-- Overlay Background -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Login Container -->
    <div class="relative bg-white bg-opacity-90 shadow-lg rounded-lg p-8 max-w-sm w-full z-10">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
            <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
            <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Login</h1>


        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="text" name="email" id="email" placeholder="Enter Email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Password..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Remember Me</label>
                </div>
                <a href="/forget-password" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold transition transform hover:scale-105">
                <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login
            </button>
        </form>
        <!-- Login Form End -->


        <!-- Register Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-700">Belum Punya Akun? <a href="/register" class="text-indigo-600 hover:text-indigo-800 font-medium">Register</a></p>
        </div>
    </div>
</body>

</html>
