<div class="site-wrap">
    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
              <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar container bg-white h-40" role="banner" style="background-image: url({{ asset('frontend/images/hero_2.jpg') }});">

      <!-- <div class="container"> -->
        <div class="row d-flex justify-content-center">
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
                                <li class="ml-xl-3 login">
                                    <a href="{{ route('profile') }}"><span class="border-left pl-xl-4"></span>My Profile</a>
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
                        <li><a href="{{ route('new_ad') }}" class="cta"><span class="bg-primary text-white rounded">+ Post an Ad</span></a></li>
                    </ul>
                </nav>
            </div>

            <div>
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-12">
                            <div class="form-search-wrap mt-5" data-aos="fade-up" data-aos-delay="200">
                                <form action="/search" method="GET">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                                            <input type="text" name="query" class="form-control rounded" placeholder="What are you looking for?">
                                        </div>
                                        <autocomplete></autocomplete>
                                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                            <div class="select-wrap">
                                                <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                                <select class="form-control rounded" name="categorySearch" id="">
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
        </div>
    </header>
