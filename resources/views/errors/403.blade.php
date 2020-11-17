@extends ('layouts.user')

@section ('title', 'Get More Ads')

@section('extra-css')
	<link rel="stylesheet" href="{{ asset('css/pricing.css') }}">
@endsection

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="d-md-flex justify-content-end">
                <p class="mr-1">Your Balance: {{ config('for-sale.currency') }}{{ $balance }}</p>
                <a href="/myaccount/wallet/load-account" class="btn bg-white btn-sm rounded-lg" style="height: fit-content;">Increase Balance</a>
            </div>
			<h1>You have reached your ad-posting limit. To post more ads take a look at our offers.</h1>

			<div class="d-md-flex justify-content-center">
				<div class="price-table-wrapper">
				  <div class="pricing-table">
				    <h2 class="pricing-table__header">- ADVANCED -</h2>
				    <h3 class="pricing-table__price">{{ config('for-sale.currency')}}30</h3>
				    <a class="pricing-table__button" href="{{route('3_additional_ads') }}">
				      Buy Now!
				    </a>
				    <ul class="pricing-table__list">
				      <li>4 additional ads</li>
				      <li>20% discount</li>
				      <li>24 hour support</li>
				    </ul>
				  </div>

				  <div class="pricing-table featured-table">
				    <h2 class="pricing-table__header">- PREMIUM -</h2>
				    <h3 class="pricing-table__price">{{ config('for-sale.currency')}}80</h3>
				    <a class="pricing-table__button" href="{{ route('10_additional_ads') }}">
				      Buy Now!
				    </a>
				    <ul class="pricing-table__list">
				      <li>10 additional ads</li>
				      <li>25% discount</li>
				      <li>24 hour support</li>
				    </ul>
				  </div>
				</div>
			</div>
		</div>
	</div>
@endsection
