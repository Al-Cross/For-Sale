<a href="{{ $ad->path() }}"
    class="img d-block"
    style="background-image: url({{ asset('storage/' . $ad->mainImage()) }})">
</a>
<div class="lh-content">
    <span class="category">{{ $ad->section->category->name }}</span>
    <span class="listings-single">{{ $ad->price }}</span>
    @auth
	    <favourite :ad="{{ $ad }}"></favourite>
    @else
    	<a href="{{ route('login') }}" id="{{ 'unique_' . $ad->slug }}" class="bookmark"><span class="icon-heart"></span></a>
    	<span id="{{ 'unique_' . $ad->id }}" role="tooltip">
	    	Log in to observe this ad
			<div id="arrow" data-popper-arrow></div>
	    </span>
    @endauth
    <h3><a href="{{ $ad->path() }}">{{ Str::limit($ad->title, 60)}}</a></h3>
    <address>{{ $ad->city->city }}</address>
</div>
