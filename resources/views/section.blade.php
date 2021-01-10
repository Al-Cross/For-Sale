@extends('layouts.app')

@section('title', $section->name)

@section('content')
<div class="site-section" style="margin-top: 200px;">
	<div class="container">
		<filters :section="{{ $section }}"
				:private="{{ $private }}"
				:business="{{ $business }}"
				:count="{{ $count }}">
		</filters>
	</div>
</div>
@endsection
