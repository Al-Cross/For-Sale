<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials._head')
</head>
<body>
    @include('partials.header')
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('partials.footer')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
</body>
</html>
