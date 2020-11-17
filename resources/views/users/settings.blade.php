@extends ('layouts.user')

@section ('title', 'Profile Settings')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="button-container mb-5 border-bottom d-md-flex justify-content-between">
                <div>
                    <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                    <a href="{{ route('messages') }}" class="draw-outline draw-outline--tandem"> Messages</a>
                    <a href="#contact" class="draw-outline draw-outline--tandem">Settings</a>
                </div>
                <div class="d-md-flex">
                    <p class="mr-1">Your Balance: {{ config('for-sale.currency') }}{{ $balance }}</p>
                    <a href="myaccount/wallet/load-account" class="btn bg-white btn-sm rounded-lg" style="height: fit-content;">Increase Balance</a>
                </div>
            </div>

            <profile-sections :user="{{ $user }}"></profile-sections>
        </div>
    </div>
@endsection
