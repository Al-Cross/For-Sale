<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials._head')
</head>
<body>
    <div id="app">
        @include('partials.header')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
    @include('partials.footer')

    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
</body>
</html>
