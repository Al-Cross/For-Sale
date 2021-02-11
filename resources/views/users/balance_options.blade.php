@extends ('layouts.user')

@section ('title', 'Load Your Account')

@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/scss/balance.scss') }}">
@endsection

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<h1>Choose the sum you would like to load</h1>
			<form action="{{ route('process_payment') }}" method="POST">
				@csrf
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="first">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}20
						<input type="radio" id="20" name="value" class="selected" value="2000" onclick="bg('20', 'first')" checked>
						<span class="checkmark"></span>
					</div>
				</label>
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="second">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}50
						<input type="radio" id="50" name="value" class="selected" value="5000" onclick="bg('50', 'second')">
						<span class="checkmark"></span>
					</div>
				</label>
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="third">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}70
						<input type="radio" id="70" name="value" value="7000" onclick="bg('70', 'third')">
						<span class="checkmark"></span>
					</div>
				</label>
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="forth">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}100
						<input type="radio" id="100" name="value" value="10000" onclick="bg('100', 'forth')">
						<span class="checkmark"></span>
					</div>
				</label>
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="fifth">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}500
						<input type="radio" id="500" name="value" value="50000" onclick="bg('500', 'fifth')">
						<span class="checkmark"></span>
					</div>
				</label>
				<label class="d-md-flex radio-field rounded-lg shadow-sm text-white w-50" id="sixth">
					<div class="p-2 pl-5">
						{{ config('for-sale.currency') }}1000
						<input type="radio" id="1000" name="value" value="100000" onclick="bg('1000', 'sixth')">
						<span class="checkmark"></span>
					</div>
				</label>
				<a href="{{ url()->previous() }}">Cancel</a>
				<button type="submit" class="btn btn-primary w-25 rounded-lg" style="margin-left: 210px;">
					Continue
					<i class="fas fa-arrow-right ml-3"></i>
				</button>
			</form>
		</div>
	</div>
@endsection

@section ('scripts')
	<script>
		function bg(id, label) {
			var selected = document.getElementById(id);
			var grandParents = document.getElementsByClassName('radio-field');
			var parents = document.getElementsByClassName('pl-5');

			Array.prototype.forEach.call(parents, el => {
				el.style.backgroundColor = 'bisque';
			});

			Array.prototype.forEach.call(grandParents, el => {
				el.style.backgroundColor = 'bisque';
			});

			if (selected.checked) {
				selected.parentElement.style.backgroundColor = '#2196F3';
				document.getElementById(label).style.backgroundColor = '#2196F3';
			}
		}
	</script>
@endsection
