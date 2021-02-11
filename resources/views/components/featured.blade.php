@if ($collection->count() > 3)
    <div class="d-block d-md-flex listing vertical">
        <a href="{{ $ad->path() }}"
            class="img d-block"
            style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
        </a>
        <span class="badge badge-info rounded">FEATURED</span>
        <div class="lh-content">
            <span class="category">{{ $ad->section->category->name }}</span><br>
            <span class="listings-single">{{ config('for-sale.currency') }}{{ $ad->price }}</span>
            @auth
                <favourite :ad="{{ $ad }}"></favourite>
            @else
                <a href="{{ route('login') }}" id="{{ 'unique_' . $ad->slug }}" class="bookmark"><span class="icon-heart"></span></a>
                <span id="{{ 'unique_' . $ad->id }}" role="tooltip">
                    Log in to observe me
                    <div id="arrow" data-popper-arrow></div>
                </span>
            @endauth
            <h3 style="height: 41px;"><a href="{{ $ad->path() }}">{{ Str::limit($ad->title, 40) }}</a></h3>
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
                <span class="category">{{ $ad->section->category->name }}</span><br>
                <span class="listings-single">{{ $ad->price }}</span>
                @auth
                    <favourite :ad="{{ $ad }}"></favourite>
                @else
                    <a href="{{ route('login') }}" id="{{ 'unique_' . $ad->slug }}" class="bookmark"><span class="icon-heart"></span></a>
                    <span id="{{ 'unique_' . $ad->id }}" role="tooltip">
                        Log in to observe me
                        <div id="arrow" data-popper-arrow></div>
                    </span>
                @endauth
                <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
                <address>{{ $ad->city->city }}</address>
            </div>
        </div>
	</div>
@endif
