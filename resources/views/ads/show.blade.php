@extends('layouts.app')

@section('title', $ad->title)

@section ('content')
<div class="site-section">
	<div class="container">
	    <div class="row" style="margin-top: 200px;">
	    	<div class="col-lg-8 mb-5">
	    		<a href="{{'/' . $ad->section->category->slug }}">{{ $ad->section->category->name }}</a>
	    		<i class="fas fa-circle fa-xs ml-2 mr-2"></i>
	    		<a href="{{ route('section', [$ad->section->category->slug, $ad->section->slug]) }}">{{ $ad->section->name }}</a>
	    		<i class="fas fa-circle fa-xs ml-2 mr-2"></i>
	    		<span>{{ $ad->city->city }}</span>
	    	</div>
		    <div class="col-lg-8">
		    	<div class="d-flex justify-content-between">
		    		<h2 class="h5 mb-4 text-black">{{ $ad->title }}</h2>
					@auth
					    <favourite :ad="{{ $ad }}"></favourite>
				    @else
				    	<a href="{{ route('login') }}" id="{{ 'unique_' . $ad->slug }}" class="bookmark"><span class="icon-heart"></span></a>
				    	<span id="{{ 'unique_' . $ad->id }}" role="tooltip">
					    	Log in to observe this ad
							<div id="arrow" data-popper-arrow></div>
					    </span>
				    @endauth
		    	</div>

		        <div class="mb-4">
			        <div class="slide-one-item home-slider owl-carousel">
			        	@foreach ($ad->images as $image)
			            <div><img src="{{ asset('/storage/' . $image->path) }}" alt="Image" class="img-fluid"></div>
			            @endforeach
			        </div>
		        </div>

				<div class="d-flex justify-content-end">
			        <h4 class="h5 mb-4 text-black font-weight-bold">{{ config('for-sale.currency') }}{{ $ad->price }}</h4>
				</div>
				<div class="d-flex justify-content-between mb-4">
					<div class="d-flex justify-content-center border border-4 pl-2 pr-2 rounded w-25">
						Condition: {{ $ad->condition }}
					</div>
					<div class="d-flex justify-content-center border border-4 pl-2 pr-2 rounded w-25">
						Type: {{ $ad->type }}
					</div>
					<div class="d-flex justify-content-center border border-4 pl-2 pr-2 rounded">
						Delivery on: {{ $ad->delivery }}
					</div>
				</div>

		        <h4 class="h5 mb-4 text-black">Description</h4>
		        <p>{{ $ad->description }}</p>
		        <hr>

		        <div class="d-flex justify-content-between mb-5">
		        	<small>Added on: {{ $ad->created_at->format("h:s, d F Y") }}</small>
		        	<small>Visits: {{ $ad->views }}</small>
		        	<small>Ad ID: {{ $ad->id }}</small>
		        </div>
		        @if(!Auth::check())
				    <span class="font-weight-bold">
				    	<a href="{{ route('login') }}">Log in</a>
				    	or <a href="{{ route('register') }}">Register</a>
				    	to send a message to the owner.</span>
			    @elseif(Auth::user() != $ad->owner)
			    	@include('partials._message-form')
			    @endif
		    </div>

		    <div class="col-lg-4 ml-auto">
		        <div class="mb-5">
		        	<div class="card bg-light p-3">
		        		From:
		        		<div class="row">
		        			<img src="{{ asset('/storage/' . $ad->owner->avatar) }}" width="150" height="150" class="mr-2 rounded">
			        		<div class="col">
			        			<span class="font-weight-bold">{{ $ad->owner->name }}</span>
				        		@if(Cache::has('user-is-online-' . $ad->owner->id))
				        			<div class="status-page-link mt-3">
								    	<div class="status-dot ml-lg-n2"></div>now online
								    </div>
				        		@endif
			        		</div>
		        		</div>
		        		<a href="{{ route('user_ads', $ad->owner->name) }}" class="btn btn-dark rounded mt-3">User Ads</a>
		        		@if(Auth::check())
			        		<a href="#message-form" class="btn btn-dark rounded mt-3">Send Message</a>
		        		@endif
		        	</div>
		        </div>
		    </div>
	    </div>
	    @if(!$otherAds->isEmpty())
		    @include('partials._other-ads-of-the-user')
	    @endif
	</div>
</div>
@endsection

@section('scripts')
<script>
	var ad = @json($ad);
	var phone = document.getElementById('phone');
	document.documentElement.scrollTop = 0;

	if (phone) {
		phone.style = 'display: none';
	}

	function show() {
		document.getElementById('dummy').style = 'display: none';
		phone.style.display = 'block';
	}

	var button = document.querySelector(`#unique_${ad.slug}`);
	var tooltip = document.querySelector(`#unique_${ad.id}`);
</script>
<script type="module" src="{{ mix('/js/tooltip.js') }}"></script>
<script>

</script>
@endsection
