<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>My Profile</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials._head')
</head>
<body>
    <div id="user">
        @include('users._header')

        <main class="pt-4">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>
    </div>
    <script src="{{ mix('/js/user.js') }}"></script>
    @include('partials.footer')

    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
</body>
</html>
