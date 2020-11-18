@extends ('layouts.user')

@section ('title', 'My Profile')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="button-container mb-5 border-bottom d-md-flex justify-content-between">
                <div>
                    <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                    <a href="{{ route('messages') }}" class="draw-outline draw-outline--tandem"> Messages</a>
                    <a href="/myaccount/settings" class="draw-outline draw-outline--tandem">Settings</a>
                </div>

                @if(Auth::user()->ad_limit !== 0)
                    <span class="text-center">Ad Slots Remaining: {{ Auth::user()->ad_limit }}</span>
                @endif
                <div class="d-md-flex">
                    <p class="mr-1">Your Balance: {{ config('for-sale.currency') }}{{ $balance }}</p>
                    <a href="myaccount/wallet/load-account" class="btn bg-white btn-sm rounded-lg" style="height: fit-content;">Increase Balance</a>
                </div>
            </div>

            <h3 class="font-weight-bold text-center">My Ads</h3>
            <a href="{{ route('new_ad') }}" class="btn btn-primary rounded" style="position: fixed;">New Ad</a><br>
            @if(Auth::user()->ad_limit == 0)
                <h3 class="font-weight-bold text-center"><a href="#">You have reached your ad limit. Get more slots here!</a></h3>
            @endif

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
                                    <span class="listings-single">{{ config('for-sale.currency') }}{{ $ad->price }}</span>
                                    <div>
                                        <a href="{{ route('edit_ad', $ad->slug) }}"
                                            class="btn btn-warning btn-sm rounded"
                                            style="position: absolute; right: 20%;">Edit</a>
                                        <form action="{{ route('delete_ad', $ad->id) }}" method="POST" style="position: absolute; right: 4%;">
                                            @csrf
                                            @method('DELETE')
                                            <confirm-delete></confirm-delete>
                                        </form>
                                    </div>
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
