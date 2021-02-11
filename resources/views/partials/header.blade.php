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
        <div class="row">
            <div class="col-4 col-xl-2">
                <h1 class="mb-0 site-logo">
                    <a href="/" class="text-black mb-0">For<span class="text-primary">Sale</span></a>
                </h1>
            </div>
            <div class="col-12 col-md-10 d-xl-block">
                <nav class="site-navigation position-relative" role="navigation">
                    <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block d-lg-table">
                        @if (Route::has('login'))
                            @auth
                                <li class="login">
                                    <a href="/observed"><span class="pl-xl-4"></span>Favourites</a>
                                </li>
                                <li>
                                    <notifications></notifications>
                                </li>
                                <li class="ml-xl-3 login">
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
                                 @if (Auth::check() && Auth::user()->type !== 'basic')
                                    <li>
                                        <a href="#" class="cta">
                                            <span class="bg-primary text-white rounded">{{ strtoupper(Auth::user()->type) }}</span>
                                        </a>
                                    </li>
                                @endif
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

            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-12">
                        <div class="form-search-wrap mt-5" data-aos="fade-up" data-aos-delay="200">
                            <form action="/search" method="GET">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <input type="text"
                                                name="searchTerm"
                                                id="term"
                                                class="form-control rounded"
                                                placeholder="Just type it..."
                                                value="{{ app('request')->input('searchTerm') }}">
                                    </div>
                                    <autocomplete :errors="{{ $errors }}"></autocomplete>
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-2">
                                        <select name="distance" id="distance" class="form-control rounded">
                                            <option value="{{ null }}">+0 km</option>
                                            <option value="10" {{ app('request')->input('distance') == 10 ? 'selected' : '' }}>+10 km</option>
                                            <option value="30" {{ app('request')->input('distance') == 30 ? 'selected' : '' }}>+30 km</option>
                                            <option value="50" {{ app('request')->input('distance') == 50 ? 'selected' : '' }}>+50 km</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <div class="select-wrap">
                                            <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                            <select class="form-control rounded" name="categorySearch" id="">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                            {{ app('request')->input('categorySearch') == $category->id ? 'selected' : '' }}
                                                    >
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-1 ml-auto">
                                        <button type="submit" class="btn btn-primary btn-sm w-75 rounded">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
