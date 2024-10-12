<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/bg.jpg');">

    <!-- Overlay Background -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Register Container -->
    <div class="relative bg-white bg-opacity-90 shadow-lg rounded-lg p-8 max-w-sm w-full z-10">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
            <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
            <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Register</h1>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="text" id="email" placeholder="Enter Email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Telephone Field -->
        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">Telephone</label>
            <input type="text" id="telephone" placeholder="Enter Telephone..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" placeholder="Enter Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="confirm-password" placeholder="Enter Confirm Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Register Button -->
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold transition transform hover:scale-105">
                <i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;Register
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-700">Sudah Punya Akun? <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Login</a></p>
        </div>
    </div>
</body>

</html>
