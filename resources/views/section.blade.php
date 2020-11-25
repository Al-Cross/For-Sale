@extends('layouts.app')

@section('title', $section->name)

@section('content')
<div class="site-section" style="margin-top: 200px;">
	<div class="container">
		<div class="row">
            <div class="col-12 block-13">
                @foreach($featured as $feature)
                	@if ($featured->count() > 3)
		                <div class="owl-carousel nonloop-block-13">
	                        <div class="d-block d-md-flex listing vertical">
	                            <a href="{{ $feature->path() }}"
	                                class="img d-block"
	                                style="background-image: url({{ asset('storage/' . $feature->mainImage()) }})">
	                            </a>
	                            <div class="lh-content">
	                                <span class="category">{{ $feature->section->category->name }}</span><br>
	                                <span class="listings-single">{{ config('for-sale.currency') }}{{ $feature->price }}</span>
	                                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
	                                <h3><a href="{{ $feature->path() }}">{{ $feature->title }}</a></h3>
	                                <address>{{ $feature->city->city }}</address>
	                            </div>
	                        </div>
	                    </div>
                    @else
                    	<div class="col-lg-6">
						<div class="d-block d-md-flex listing">
			                <a href="{{ $feature->path() }}"
			                    class="img d-block"
			                    style="background-image: url({{ asset('storage/images/img_1.jpg') }})">
			                </a>
			                <span class="badge badge-info rounded">FEATURED</span>
			                <div class="lh-content">
			                    <span class="category">{{ $section->category->name }}</span><br>
			                    <span class="listings-single">{{ $feature->price }}</span>
			                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
			                    <h3><a href="{{ $feature->path() }}">{{ $feature->title }}</a></h3>
			                    <address>{{ $feature->city->city }}</address>
			                </div>
			            </div>
					</div>
                    @endif
                @endforeach
            </div>
        </div>

		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					@foreach($adsInSection as $ad)
						<div class="col-lg-6">
							<div class="d-block d-md-flex listing vertical">
				                <a href="{{ $ad->path() }}"
				                    class="img d-block"
				                    style="background-image: url({{ asset('storage/images/img_1.jpg') }})">
				                </a>
				                <div class="lh-content">
				                    <span class="category">{{ $section->category->name }}</span>
				                    <span class="listings-single">{{ $ad->price }}</span>
				                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
				                    <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
				                    <address>{{ $ad->city->city }}</address>
				                </div>
				            </div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="col-lg-3 ml-auto">
		        <div class="mb-5">
			        <h3 class="h5 text-black mb-3">Filters</h3>
			        <form action="#" method="post">
			            <div class="form-group">
				            <input type="text" placeholder="What are you looking for?" class="form-control">
			            </div>
			            <div class="form-group">
				            <div class="select-wrap">
				                <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
				                <select class="form-control" name="" id="">
				                    <option value="">All Categories</option>
				                    <option value="" selected="">Real Estate</option>
				                    <option value="">Books &amp;  Magazines</option>
				                    <option value="">Furniture</option>
				                    <option value="">Electronics</option>
				                    <option value="">Cars &amp; Vehicles</option>
				                    <option value="">Others</option>
				                </select>
			                </div>
			            </div>
			            <div class="form-group">
				            <div class="wrap-icon">
				                <span class="icon icon-room"></span>
				                <input type="text" placeholder="Location" class="form-control">
				            </div>
			            </div>
			        </form>
		        </div>

		        <div class="mb-5">
			        <form action="#" method="post">
			            <div class="form-group">
				            <p>Radius around selected destination</p>
			            </div>
			            <div class="form-group">
				            <input type="range" min="0" max="100" value="20" data-rangeslider>
			            </div>
			        </form>
		        </div>

		        <div class="mb-5">
			        <form action="#" method="post">
			            <div class="form-group">
			              <p>Category 'Real Estate' is selected</p>
			              <p>More filters</p>
			            </div>
			            <div class="form-group">
			              <ul class="list-unstyled">
			                <li>
			                  <label for="option1">
			                    <input type="checkbox" id="option1">
			                    Residential
			                  </label>
			                </li>
			                <li>
			                  <label for="option2">
			                    <input type="checkbox" id="option2">
			                    Commercial
			                  </label>
			                </li>
			                <li>
			                  <label for="option3">
			                    <input type="checkbox" id="option3">
			                    Industrial
			                  </label>
			                </li>
			                <li>
			                  <label for="option4">
			                    <input type="checkbox" id="option4">
			                    Land
			                  </label>
			                </li>
			              </ul>
			            </div>
			        </form>
		        </div>

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
