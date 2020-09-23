@extends ('layouts.user')

@section ('title', 'My Profile')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="button-container mb-5 border-bottom">
                <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                <a href="{{ route('messages') }}" class="draw-outline draw-outline--tandem"> Messages</a>
                <a href="#contact" class="draw-outline draw-outline--tandem">Settings</a>
            </div>

            <h3 class="font-weight-bold text-center">My Ads</h3>

            <a href="{{ route('new_ad') }}" class="btn btn-primary rounded" style="position: fixed;">New Ad</a>
            <div class="tab-content" style="width: 645px; margin: 100px auto; position: relative;">
            	<div class="tab-pane-fade" role="tabpanel" style="text-align: center;">
                    @if ($userAds->count() > 0)
                        @foreach ($userAds as $ad)
                            <div class="d-block d-md-flex listing vertical">
                                <a href="{{ $ad->path() }}"
                                    class="img d-block"
                                    style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
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
                    @else
                		<h3 class="mb-5">You don't have active ads</h3>
                    @endif
            	</div>
            </div>
		</div>
	</div>
@endsection
