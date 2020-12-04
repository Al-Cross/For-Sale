@extends('layouts.app')

@section('title', 'Search results')

@section('content')
<div class="site-section" style="margin-top: 200px;">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					@forelse ($results as $ad_section)
						@if ($ad_section->name)
							@foreach ($ad_section->ads as $ad)
								<div class="col-lg-6">
									<div class="d-block d-md-flex listing vertical">
						                <a href="{{ $ad->path() }}"
						                    class="img d-block"
						                    style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
						                </a>
						                <div class="lh-content">
						                    <span class="category">{{ $ad->section->category->name }}</span>
						                    <span class="listings-single">{{ $ad->price }}</span>
						                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
						                    <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
						                    <address>{{ $ad->city->city }}</address>
						                </div>
						            </div>
								</div>
							@endforeach
						@else
							<div class="col-lg-6">
								<div class="d-block d-md-flex listing vertical">
					                <a href="{{ $ad_section->path() }}"
					                    class="img d-block"
					                    style="background-image: url({{ asset('storage/' . $ad_section->mainImage()) }})">
					                </a>
					                <div class="lh-content">
					                    <span class="category">{{ $ad_section->section->category->name }}</span>
					                    <span class="listings-single">{{ $ad_section->price }}</span>
					                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
					                    <h3><a href="{{ $ad_section->path() }}">{{ $ad_section->title }}</a></h3>
					                    <address>{{ $ad_section->city->city }}</address>
					                </div>
					            </div>
							</div>
						@endif
					@empty
						<span class="font-weight-bold">Nothing found.</span>
					@endforelse
				</div>
			</div>

			<div class="col-lg-3 ml-auto">
		        <div class="mb-5">
			        <h3 class="h6 mb-3">More Info</h3>
			        <p>
				        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatem placeat facilis, reprehenderit eius officiis.
				    </p>
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection
