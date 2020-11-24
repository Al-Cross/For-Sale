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
            <tabs>
                <tab name="Active" :selected="true">
                    <a href="{{ route('new_ad') }}" class="btn btn-primary rounded" style="position: fixed;">New Ad</a><br>
                    @if(Auth::user()->ad_limit == 0)
                        <h3 class="font-weight-bold text-center"><a href="#">You have reached your ad limit. Get more slots here!</a></h3>
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
                                                <small class="text-muted">
                                                    From: {{ $ad->created_at->calendar() }} till:
                                                    {{ $ad->created_at->addMonth()->format('Y-m-d h:s A') }}
                                                </small>
                                                <address>{{ $ad->city->city }}</address>
                                                <div class="d-md-flex justify-content-end">
                                                    <div class="bg-gray border mr-2 pl-1 pr-1 rounded">
                                                        <i class="far fa-comment"></i> {{ $ad->messages_count }}
                                                    </div>
                                                    @if ($ad->created_at < \Carbon\Carbon::now()->subDays(27))
                                                        <form action="{{ route('extend-ad', $ad->id) }}" method="POST" class="mr-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-dark btn-sm rounded">
                                                                Renew for {{ config('for-sale.currency') }}
                                                                {{ config('for-sale.prices.ad_extention')}}
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
                                    @else
                                        <h3 class="mb-5">You don't have any active ads yet</h3>
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
                            @if ($userAds->count() > 0 && $ad->archived)
                                @foreach ($userAds as $ad)
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
