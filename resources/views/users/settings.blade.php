@extends ('layouts.user')

@section ('title', 'Profile Settings')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="button-container mb-5 border-bottom">
                <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                <a href="{{ route('messages') }}" class="draw-outline draw-outline--tandem"> Messages</a>
                <a href="#contact" class="draw-outline draw-outline--tandem">Settings</a>
            </div>

            <profile-sections :user="{{ $user }}"></profile-sections>
        </div>
    </div>
@endsection
