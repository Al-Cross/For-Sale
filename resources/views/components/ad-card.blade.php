<div class="col-lg-6">
	<div class="d-block d-md-flex listing vertical">
        <a href="{{ $ad->path() }}"
            class="img d-block"
            style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
        </a>
        <div class="lh-content">
            <span class="category">{{ $ad->condition }}</span>
            <span class="listings-single">{{ $ad->price }}</span>
            <favourite :ad="{{ $ad }}"></favourite>
            <h3><a href="{{ $ad->path() }}">{{ $ad->title }}</a></h3>
            <address>{{ $ad->city->city }}</address>
        </div>
    </div>
</div>
