@extends('layouts.app')

@section('title', 'Search results')

@section('content')
<div class="site-section" style="margin-top: 200px;">
	<div class="container">
		<filters :private="{{ $private }}" :business="{{ $business }}" :count="{{ $count }}"></filters>
	</div>
</div>
@endsection
