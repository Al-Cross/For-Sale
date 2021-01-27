<div class="col-md-7 text-left border-primary mb-4">
	<h3 class="font-weight-light text-primary mt-5">Other Ads Of {{ $ad->owner->name }}</h3>
</div>
<div class="row mt-3">
	@foreach($otherAds->split(2) as $chunks)
		<div class="col-lg-6">
			@foreach($chunks as $ad)
				<div class="d-block d-md-flex listing">
		           <x-ad-card :ad="$ad"></x-ad-card>
				</div>
			@endforeach
		</div>
	@endforeach
</div>
<div class="row d-md-flex justify-content-center">
	<a href="{{ route('user_ads', $ad->owner->name) }}" class="btn btn-outline-dark rounded w-50 mt-3">See All Ads Of This User</a>
</div>
