@extends ('layouts.user')

@section ('title', 'Profile Deleted')

@section('content')
<div class="site-section bg-secondary">
	<div class="container d-flex justify-content-center">
		<div class="w-75 mt-5 rounded-lg text-center" style="height: 300px; vertical-align: middle;">
			<h1 class="mb-0 site-logo">
                <a href="/" class="text-black mb-0">For<span class="text-primary">Sale</span></a>
            </h1>
			<p>Sorry to see you go!</p>
			<p>Your profile has been deleted!</p>
			<a href="/" class="btn btn-primary w-50 rounded-lg">Back To The Main Page</a>
		</div>
	</div>
</div>
@endsection
