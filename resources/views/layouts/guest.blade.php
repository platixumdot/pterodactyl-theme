<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('pltx-theme.brand.name', 'PLTX Theme') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/pltx-theme/css/theme.css') }}">
</head>
<body class="guest-shell">
    <div class="theme-bg"></div>
    <div class="theme-grid"></div>
    <div class="guest-card">
        @yield('content')
    </div>
    <script src="{{ asset('vendor/pltx-theme/js/theme.js') }}" defer></script>
</body>
</html>
