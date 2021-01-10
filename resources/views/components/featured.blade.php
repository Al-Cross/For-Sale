@if ($collection->count() > 3)
    <div class="d-block d-md-flex listing vertical">
        <a href="{{ $ad->path() }}"
            class="img d-block"
            style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
        </a>
        <span class="badge badge-info rounded">FEATURED</span>
        <div class="lh-content">
            <span class="category">{{ $ad->condition }}</span><br>
            <span class="listings-single">{{ config('for-sale.currency') }}{{ $ad->price }}</span>
            <a href="#" class="bookmark"><span class="icon-heart"></span></a>
            <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
            <address>{{ $ad->city->city }}</address>
        </div>
    </div>
@else
	<div class="col-lg-9">
		<div class="d-block d-md-flex listing">
            <a href="{{ $ad->path() }}"
                class="img d-block"
                style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
            </a>
            <span class="badge badge-info rounded">FEATURED</span>
            <div class="lh-content">
                <span class="category">{{ $ad->condition }}</span><br>
                <span class="listings-single">{{ $ad->price }}</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
                <address>{{ $ad->city->city }}</address>
            </div>
        </div>
	</div>
@endif
