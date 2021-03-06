<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>

    <script>
        window.App = {!! json_encode([
            "user" => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!}
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials._head')
    @yield('extra-css')
</head>
<body>
    <div id="user">
        @include('users._header')

        <main class="pt-5">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>
    </div>
    <script src="{{ mix('/js/user.js') }}"></script>
    @include('partials.footer')

    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
    @yield('scripts')
</body>
</html>
