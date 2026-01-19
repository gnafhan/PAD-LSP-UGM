<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lembaga Sertifikasi Profesi UGM - Sertifikasi berkualitas tinggi yang diakui BNSP untuk mahasiswa aktif">
    <meta name="theme-color" content="#0ea5e9">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>@yield('title')</title>
    
    <!-- Preload critical fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@10..48,200;10..48,300;10..48,400;10..48,500;10..48,600;10..48,700;10..48,800&display=swap" as="style">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional styles for better accessibility -->
    <style>
        /* Focus styles for better accessibility */
        *:focus {
            outline: 2px solid #0ea5e9;
            outline-offset: 2px;
        }
        
        /* Skip to main content link for screen readers */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #0ea5e9;
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
        }
        
        .skip-link:focus {
            top: 6px;
        }
        
        /* Ensure proper contrast for accessibility */
        .text-gray-700 {
            color: #374151;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
    </style>
</head>
<body class="font-inter antialiased text-gray-900 bg-white">
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    @include('home.partials.navbar')
    
    <main id="main-content" class="min-h-screen">
        @yield('content')
    </main>
    
    @include('home.partials.footer')
</body>
</html>
