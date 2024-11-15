<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome untuk ikon -->
</head>

<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/bg.jpg');">
    <!-- Overlay Background -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Login Container -->
    <div class="relative bg-white bg-opacity-90 shadow-lg rounded-lg p-8 max-w-sm w-full z-10">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
            <h2 class="text-2xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
            <h3 class="text-lg font-semibold text-gray-600">Universitas Gadjah Mada</h3>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 text-center mb-8">Masuk</h1>

        <!-- Login Buttons -->
        <a href="/login" class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold transition duration-300 transform hover:scale-105 shadow-lg mb-4 text-center block">
            <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Asesi
        </a>
        <a href="/login" class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold transition duration-300 transform hover:scale-105 shadow-lg mb-4 text-center block">
            <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Asesor
        </a>
        <a href="/login" class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold transition duration-300 transform hover:scale-105 shadow-lg mb-4 text-center block">
            <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Admin
        </a>

    </div>
</body>
</html>
