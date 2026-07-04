<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pltx-lightweight" content="{{ config('pltx-theme.features.lightweight_mode', false) ? 'true' : 'false' }}">
    <title>@yield('title', config('pltx-theme.brand.name', 'PLTX Theme'))</title>

    @unless(config('pltx-theme.features.lightweight_mode', false))
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    @endunless

    {{-- Dynamic CSS from Theme Editor (CSS variables) --}}
    <link rel="stylesheet" href="{{ route('theme.dynamic.css') }}" id="pltx-dynamic-css">
    {{-- Static compiled theme CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/pltx-theme/css/theme.css') }}">

    @stack('head')
</head>
<body class="theme-shell">
    @unless(config('pltx-theme.features.lightweight_mode', false))
    <div class="theme-bg"></div>
    <div class="theme-grid"></div>
    @endunless

    <div class="app-frame">
        @include('pltx-theme::partials.sidebar')
        <div class="app-main">
            @include('pltx-theme::partials.topbar')
            <main class="app-content">
                @include('pltx-theme::partials.update-banner')
                @if(session('status'))
                    <div class="pltx-alert pltx-alert--success" style="margin-bottom:16px;">
                        ✓ {{ session('status') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="pltx-alert pltx-alert--danger" style="margin-bottom:16px;">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('vendor/pltx-theme/js/theme.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
