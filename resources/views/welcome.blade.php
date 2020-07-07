<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Find Anything</title>

    @include('partials._head')
</head>
<body>
    <div class="site-wrap" id="app">
        <div class="site-mobile-menu">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                  <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <header class="site-navbar container py-0 bg-white" role="banner">

          <!-- <div class="container"> -->
            <div class="row align-items-center">
                <div class="col-6 col-xl-2">
                    <h1 class="mb-0 site-logo">
                        <a href="index.html" class="text-black mb-0">For<span class="text-primary">Sale</span></a>
                    </h1>
                </div>
                <div class="col-12 col-md-10 d-none d-xl-block">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                            @if (Route::has('login'))
                                @auth
                                    <li class="ml-xl-3 login">
                                        <a href="{{ url('/home') }}"><span class="border-left pl-xl-4"></span>Home</a>
                                    </li>
                                    <li>
                                        <a class="border-left pl-xl-4" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li class="ml-xl-3 login">
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>

                                    @if (Route::has('register'))
                                        <li>
                                            <a href="{{ route('register') }}"><span class="border-left pl-xl-4"></span>Register</a>
                                        </li>
                                    @endif
                                @endauth
                            @endif
                            <li><a href="#" class="cta"><span class="bg-primary text-white rounded">+ Post an Ad</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <div class="site-blocks-cover overlay"
            style="background-image: url({{ asset('frontend/images/hero_2.jpg') }});"
            data-aos="fade"
            data-stellar-background-ratio="0.5"
            >
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-12">
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-8 text-center">
                                <h1 class="" data-aos="fade-up">Find What You Are Looking For In An Instant</h1>
                                <p data-aos="fade-up" data-aos-delay="100">You can buy, sell anything you want.</p>
                            </div>
                        </div>

                        <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
                            <form action="/search" method="GET">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                                        <input type="text" name="query" class="form-control rounded" placeholder="What are you looking for?">
                                    </div>
                                    <autocomplete></autocomplete>
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <div class="select-wrap">
                                            <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                            <select class="form-control rounded" name="categorySearch">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-2 ml-auto text-right">
                                        <input type="submit" class="btn btn-primary btn-block rounded" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-light">
            <div class="container">
                <div class="overlap-category mb-5">
                    <categories-sections :categories="{{ $categories }}"></categories-sections>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h2 class="h5 mb-4 text-black">Featured Ads</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 block-13">
                        <div class="owl-carousel nonloop-block-13">
                            @foreach($ads as $ad)
                                <div class="d-block d-md-flex listing vertical">
                                    <a href="{{ $ad->path() }}"
                                        class="img d-block"
                                        style="background-image: url({{ asset('storage/images/img_1.jpg') }})">
                                    </a>
                                    <div class="lh-content">
                                        <span class="category">Cars &amp; Vehicles</span>
                                        <span class="listings-single">{{ $ad->price }}</span>
                                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                                        <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
                                        <address>Don St, Brooklyn, New York</address>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    @include('partials.footer')
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
</body>
</html>
