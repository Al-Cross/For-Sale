<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Find Anything</title>

    @include('partials._head')
    <script>
        function reposition() {
            window.localStorage.setItem('sendMeTo', 'pagination');
        }
    </script>
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
                        <a href="/" class="text-black mb-0">For<span class="text-primary">Sale</span></a>
                    </h1>
                </div>
                <div class="col-12 col-md-10 d-none d-xl-block">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                            @if (Route::has('login'))
                                @auth
                                    <li class="login">
                                        <a href="/observed"><span class="pl-xl-4"></span>Favourites</a>
                                    </li>

                                    <li>
                                        <notifications></notifications>
                                    </li>

                                    <li class="login">
                                        <a href="{{ route('profile') }}"><span class="border-left pl-xl-4"></span>My Profile</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            <span class="border-left pl-xl-4"></span>
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
                            @if (Auth::check() && Auth::user()->type !== 'basic')
                                <li>
                                    <a href="#" class="cta">
                                        <span class="bg-primary text-white rounded">{{ strtoupper(Auth::user()->type) }}</span>
                                    </a>
                                </li>
                            @endif
                            <li><a href="{{ route('new_ad') }}" class="cta"><span class="bg-primary text-white rounded">+ Post an Ad</span></a></li>
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
                                <h1 class="" data-aos="fade-up">Find Anything In An Instant</h1>
                                <p data-aos="fade-up" data-aos-delay="100">You can buy, sell anything you want.</p>
                            </div>
                        </div>

                        <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
                            <form action="/search" method="GET">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                                        <input type="text" name="searchTerm" id="term" class="form-control rounded" placeholder="Just type it...">
                                    </div>
                                    <autocomplete :errors="{{ $errors }}"></autocomplete>
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <div class="select-wrap">
                                            <span id="distance" class="icon"><span class="icon-keyboard_arrow_down"></span></span>
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
                            @foreach($featured as $feature)
                                <x-featured :collection="$featured" :ad="$feature"></x-featured>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mt-5" id="normal-ads">
                    @foreach($ads as $ad)
                        <div class="col-lg-6">
                            <div class="d-block d-md-flex listing vertical">
                               <x-ad-card :ad="$ad"></x-ad-card>
                           </div>
                       </div>
                    @endforeach
                </div>
                <span onclick="reposition()">{{ $ads->links() }}</span>
            </div>
        </div>

        <flash message="{{ session('flash') }}"></flash>
    </div>
    <script>
        var ads = @json($ads);
        var featured = @json($featured);
        var item = localStorage.getItem('sendMeTo');

        if (item) {
            window.scrollTo(0, 1550);
            window.localStorage.removeItem('sendMeTo');
        }
    </script>
    <script type="module" src="{{ mix('/js/tooltip.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @include('partials.footer')
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('partials._scripts')
</body>
</html>
