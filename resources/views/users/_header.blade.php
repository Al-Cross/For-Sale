<div class="site-wrap">
    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
              <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar container bg-white py-0" role="banner">
        <div class="row align-items-center">

            <!-- <div class="container"> -->
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
                        <li><a href="#" class="cta"><span class="bg-primary text-white rounded">+ Post an Ad</span></a></li>
                    </ul>
                </nav>
            </div>

            <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
                <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
            </div>
        </div>
    </header>
</div>
