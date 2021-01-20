@extends('layouts.user')

@section('title', $user->name)

@section('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="img-wraps">
					<img src="{{ asset('/storage/' . $user->avatar) }}" width="150" height="150" class="rounded">
				</div>
			</div>
			<h3 class="text-center font-weight-bold">{{ $user->name }}</h3>
			<user-ads :ads="{{ $userAds }}" :user="{{ $user }}"></user-ads>
		</div>
	</div>
@endsection
