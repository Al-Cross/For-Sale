@extends ('layouts.user')

@section ('title', 'Profile Settings')

@section ('extra-css')
    <link rel="stylesheet" href="{{ asset('css/animate-buttons.css') }}">
@endsection

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
            @include('partials._profile-links')

            <profile-sections :user="{{ $user }}"></profile-sections>
        </div>
    </div>
@endsection
