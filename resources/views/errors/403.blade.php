@extends ('layouts.user')

@section ('title', 'Get More Ads')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<h1>You have reached your ad-posting limit. To post more ads take a look at our offers.</h1>

			<div class="price-table-wrapper">
			  <div class="pricing-table">
			    <h2 class="pricing-table__header">- BASIC -</h2>
			    <h3 class="pricing-table__price">{{ config('for-sale.currency')}}50</h3>
			    <a target="_blank" class="pricing-table__button" href="#">
			      Buy Now!
			    </a>
			    <ul class="pricing-table__list">
			      <li>3 additional ads</li>
			      <li>20% discount</li>
			      <li>24 hour support</li>
			    </ul>
			  </div>
			  <div class="pricing-table featured-table">
			    <h2 class="pricing-table__header">- BUSINESS -</h2>
			    <h3 class="pricing-table__price">{{ config('for-sale.currency')}}80</h3>
			    <a target="_blank" class="pricing-table__button" href="#">
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
@endsection
