<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Alpine.js for dropdowns and menus -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Vite CSS only (no client-side navigation JS) -->
    @vite('resources/css/app.css')
</head>
<body>
    @include('home.home-asesi.partials.navbar')
    <main>
        @yield('content')
        @yield('scripts')
        {{-- aku nambahin scripts buat js nya ya bel ini --}}
    </main>
    @include('home.home-asesi.partials.footer')
</body>
</html>
