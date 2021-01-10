@extends ('layouts.user')

@section ('title', 'Load Your Account')

@section ('extra-css')
	<link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
@endsection

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container d-flex justify-content-center">
			<div style="height: 300px;">
				<form id="payment-form">
					<small class="font-weight-bold">Enter your credit card details and finalize the payment</small>
					@csrf
					{{-- placeholder for Elements --}}
					<div id="card-element" class="mb-4"></div>
					<div id="card-errors" role="alert"></div>
					<button id="card-button" class="stripe-button-el">
					  Load {{ config('for-sale.currency') }}{{ $toPay }}
					</button>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var stripe = Stripe('{{ config('services.stripe.key') }}');
		var elements = stripe.elements({
			fonts: [{
				cssSrc: 'https://fonts.googleapis.com/css?family=Roboto',
			}]
		});
		// Set up Stripe.js and Elements to use in checkout form
		var elements = stripe.elements();
		var style = {
			base: {
				color: "#32325D",
		        fontWeight: 500,
		        fontFamily: "Inter UI, Open Sans, Segoe UI, sans-serif",
		        fontSize: "16px",
		        fontSmoothing: "antialiased",

		        "::placeholder": {
		          color: "#CFD7DF"
				  }
				}
		};

		var card = elements.create("card", {style: style});
		card.mount("#card-element");
		card.on('change', function(event) {
			var displayError = document.getElementById('card-errors');
			if (event.error) {
			    displayError.textContent = event.error.message;
			} else {
			    displayError.textContent = '';
			}
		});

		var form = document.getElementById('payment-form');

		form.addEventListener('submit', function(ev) {
		  ev.preventDefault();
		  // Prevent the double submission of the form
	      document.getElementById('card-button').disabled = true;

	      var clientSecret = {!! json_encode($intent->client_secret) !!};
		  stripe.confirmCardPayment(clientSecret, {
		    payment_method: {
		      card: card
		    }
		  }).then(function(result) {
		    if (result.error) {
		      document.getElementById('card-button').disabled = false;
		      // Show error to your customer (e.g., insufficient funds)
		      flash(result.error.message, 'danger');
		      console.log(result.error.message);
		    } else {
		      // The payment has been processed!
		      if (result.paymentIntent.status === 'succeeded') {
		      	axios.post('/myaccount/wallet/fill', {result});

		        flash('Your account balance has been increased!');
		      }
		    }
		  });
		});
	</script>
@endsection
