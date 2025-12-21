<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>@yield('title')</title>
    <!-- Di layout head section -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Vite assets for custom styles -->
    @vite('resources/css/app.css')
    
    <!-- Alpine.js for navbar interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    @if (Auth::user()->level == 'admin')
        @include('home.home-admin.partials.navbar')
        <div class="flex">
            @include('home.home-admin.partials.sidebar')
            <main class="flex-1">
                @yield('content')
                @yield('scripts')
            </main>
        </div>
    @elseif (Auth::user()->level == 'asesi')
        @include('home.home-asesi.partials.navbar')
        <main>
            @yield('content')
            @yield('scripts')
        </main>
    @endif
    @include('home.home-admin.partials.footer')
</body>
</html>
