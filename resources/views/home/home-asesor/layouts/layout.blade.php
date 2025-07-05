<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('home.home-asesor.partials.navbar')
    @include('home.home-asesor.partials.sidebar')

    <main>
        @yield('content')
    </main>

    @include('home.home-asesor.partials.footer')
</body>
</html>
