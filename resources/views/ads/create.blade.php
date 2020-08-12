@extends('layouts.user')

@section('content')
	<div class="site-section bg-secondary">
		<div class="container">
            <div class="button-container mb-5 border-bottom">
                <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                <a href="#profile" class="draw-outline draw-outline--tandem"> Messages</a>
                <a href="#contact" class="draw-outline draw-outline--tandem">Settings</a>
            </div>

            <h3 class="font-weight-bold text-center">Post A New Ad</h3>

            @if (isset($errors) && count($errors))
                        @foreach($errors->all() as $error)
                        <ul class="mt-4">
                            <li class="text-danger">{{ $error }} </li>
                        </ul>
                        @endforeach
            @endif

            <form action="{{ route('create_ad') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf


                <a href="" @click.prevent="$modal.show('category-pick')">Click to pick a category</a>
                <category-pick :categories="{{ json_encode($categories) }}"></category-pick>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="title">Title</label>
                        <input type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title" value="{{ old('title') }}"
                                required
                                autocomplete="title"
                                autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="price">Price</label>
                        <input type="text"
                                class="form-control @error('price') is-invalid @enderror"
                                name="price"
                                value="{{ old('price') }}"
                                required
                                autocomplete="price"
                                autofocus>

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12 radio-toolbar">
                        <span>Condition</span>
                        <div>
                            <input type="radio"
                                    class="form-control btn btn-success @error('condition') is-invalid @enderror"
                                    name="condition"
                                    id="radioNew"
                                    value="new"
                                    autofocus><label for="radioNew">New</label>
                            <input type="radio"
                                    class="form-control btn btn-success @error('condition') is-invalid @enderror"
                                    name="condition"
                                    id="radioUsed"
                                    value="used"
                                    autofocus><label for="radioUsed">Used</label>
                        </div>
                        @error('condition')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12 radio-toolbar">
                        <span>Type</span>
                        <div>
                            <input type="radio"
                                    class="form-control btn btn-success @error('type') is-invalid @enderror"
                                    name="type"
                                    id="radioPrivate"
                                    value="private"
                                    autofocus><label for="radioPrivate">Private</label>
                            <input type="radio"
                                    class="form-control btn btn-success @error('type') is-invalid @enderror"
                                    name="type"
                                    id="radioBusiness"
                                    value="business"
                                    autofocus><label for="radioBusiness">Business</label>
                        </div>
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12 radio-toolbar">
                        <span>Delivery is on the</span>
                        <div>
                            <input type="radio"
                                    class="form-control btn btn-success @error('delivery') is-invalid @enderror"
                                    name="delivery"
                                    id="radioSeller"
                                    value="seller"
                                    autofocus><label for="radioSeller">Seller</label>
                            <input type="radio"
                                    class="form-control btn btn-success @error('delivery') is-invalid @enderror"
                                    name="delivery"
                                    id="radioBuyer"
                                    value="buyer"
                                    autofocus><label for="radioBuyer">Buyer</label>
                            <input type="radio"
                                    class="form-control btn btn-success @error('delivery') is-invalid @enderror"
                                    name="delivery"
                                    id="handover"
                                    value="personal handover"
                                    autofocus><label for="handover">Personal Handover</label>
                        </div>
                        @error('delivery')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="description">Description</label>
                        <textarea rows="9"
                                class="form-control @error('description') is-invalid @enderror"
                                name="description"
                                required
                                autocomplete="description"
                                autofocus>{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="images">Images</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image[]" accept="image/*" multiple>

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="city">City</label>
                        <autocomplete style="z-index: 1000;"></autocomplete>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
@endsection
