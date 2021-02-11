@extends ('layouts.user')

@section ('title', 'My Profile')

@section ('extra-css')
    <link rel="stylesheet" href="{{ asset('css/animate-buttons.css') }}">
    <style>
        .fade-small {
            position: fixed;
            transition: opacity 2s;
            opacity: 1;
        }
        .fade-small.hide {
            opacity: 0;
        }
    </style>
@endsection

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			@include('partials._profile-links')

            <h3 class="font-weight-bold text-center">My Ads</h3>
            <tabs>
                <tab name="Active" :selected="true">
                    @if(Auth::user()->ad_limit != 0)
                        <a href="{{ route('new_ad') }}" class="btn btn-primary fade-small rounded">New Ad</a><br>
                    @else
                        <h3 class="font-weight-bold text-center">
                            <a href="/myaccount/upgrade">You have reached your ad limit. Get more slots here!</a>
                        </h3>
                    @endif

                    <div class="tab-content" style="width: 645px; margin: 100px auto; position: relative;">
                        <div class="tab-pane-fade" role="tabpanel" style="text-align: center;">
                            @if ($userAds->count() > 0)
                                @foreach ($userAds as $ad)
                                    @if (! $ad->archived)
                                        <div class="d-block d-md-flex listing vertical">
                                            <div class="lh-content">
                                                <span><a href="{{ $ad->path() }}">{{ $ad->title }}</a></span>
                                                <span class="category-profile">{{ $ad->section->category->name }}</span>
                                                <span class="listings-single">{{ config('for-sale.currency') }}{{ $ad->price }}</span><br>
                                                @if ($ad->featured)
                                                    <span class="badge badge-info rounded">FEATURED</span><br>
                                                @endif
                                                <small class="text-muted">
                                                    From: {{ $ad->created_at->calendar() }} till:
                                                    {{ $ad->created_at->addMonth()->format('Y-m-d h:s A') }}
                                                </small>
                                                <address>{{ $ad->city->city }}</address>
                                                <div class="d-md-flex justify-content-end">
                                                    <div class="bg-gray border mr-2 pl-1 pr-1 rounded">
                                                        <i class="far fa-comment"></i> {{ $ad->messages_count }}
                                                    </div>
                                                    @if (! $ad->featured)
                                                        <form action="{{ route('promote', $ad->id) }}" method="POST" class="mr-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-dark btn-sm rounded">
                                                                Promote for {{ config('for-sale.currency') }}
                                                                {{ $promotionPrice }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($ad->created_at < \Carbon\Carbon::now()->subDays(27))
                                                        <form action="{{ route('extend-ad', $ad->id) }}" method="POST" class="mr-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-dark btn-sm rounded">
                                                                Renew for {{ config('for-sale.currency') }}
                                                                {{ $extentionPrice }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('archive-ad', $ad->id) }}" method="POST" class="mr-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-warning btn-sm rounded">Archive</button>
                                                    </form>
                                                    <a href="{{ route('edit_ad', $ad->slug) }}"
                                                        class="btn btn-warning btn-sm rounded mr-2">Edit</a>
                                                    <form action="{{ route('delete_ad', $ad->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <confirm-delete></confirm-delete>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <h3 class="mb-5">You don't have any ads yet</h3>
                            @endif
                        </div>
                    </div>
                </tab>

                <tab name="Archived">
                    <div class="tab-content" style="width: 645px; margin: 100px auto; position: relative;">
                        <div class="tab-pane-fade" role="tabpanel" style="text-align: center;">
                            @if ($userAds->count() > 0)
                                @foreach ($userAds as $ad)
                                    @if($ad->archived)
                                        <div class="d-block d-md-flex listing vertical">
                                            <div class="lh-content">
                                                <span><a href="{{ $ad->path() }}">{{ $ad->title }}</a></span>
                                                <span class="category-profile">{{ $ad->section->category->name }}</span>
                                                <span class="listings-single">{{ config('for-sale.currency') }}{{ $ad->price }}</span><br>
                                                <small class="text-muted">
                                                    From: {{ $ad->created_at->calendar() }} till: {{ $ad->created_at->format('Y-m-d h:s A') }}
                                                </small>
                                                <address>{{ $ad->city->city }}</address>
                                                <div class="d-md-flex justify-content-end">
                                                    <div class="bg-gray border mr-2 pl-1 pr-1 rounded">
                                                        <i class="far fa-comment"></i> {{ $ad->messages_count }}
                                                    </div>
                                                    <form action="{{ route('activate-ad', $ad->id) }}" method="POST" class="mr-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-warning btn-sm rounded">Activate</button>
                                                    </form>
                                                    <a href="{{ route('edit_ad', $ad->slug) }}"
                                                        class="btn btn-warning btn-sm rounded mr-2">Edit</a>
                                                    <form action="{{ route('delete_ad', $ad->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <confirm-delete></confirm-delete>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <h3 class="mb-5">You don't have archived ads</h3>
                            @endif
                        </div>
                    </div>
                </tab>
            </tabs>
		</div>
	</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
       (function() {
          var timeout;
          var $window = $(window);
          var $fade = $('.fade-small');

          $window.on('scroll', function(e){
            clearTimeout(timeout);

            timeout = setTimeout(function(){
              if ($window.scrollTop() < 350) {
                $fade.removeClass('hide');
              } else {
                $fade.addClass('hide');
              }
            }, 100);
          });
        }());
    </script>
@endsection
