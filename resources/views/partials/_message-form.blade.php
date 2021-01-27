<div id="message-form" class="card mt-5 bg-light">
	<form action="{{ route('send') }}" method="POST">
		@csrf

		<div class="form-group-row">
			<div class="col-md-12">
				<div class="d-flex justify-content-between">
					<div class="p-2 mb-2">
	        			<img src="{{ asset('/storage/' . $ad->owner->avatar) }}" width="100" height="100" class="mr-2 rounded">
		        		<span class="font-weight-bold alert">{{ $ad->owner->name }}</span>
	        		</div>
						<i class="fas fa-phone-square-alt fa-2x pt-4 mr-3"></i>

					<div class="pt-4">
						<div id="dummy">
							<span>(XX) XXXXXXX</span>
							<button type="button" class="btn btn-primary rounded" onclick="show();">Show</button>
						</div>
						<span id="phone" class="font-weight-bold">{{ $ad->owner->phone }}</span>
					</div>
				</div>

				<label for="subject">Subject</label>
				<input type="text"
						name="subject"
						value="{{ old('subject') }}"
						class="form-control @error('subject') is-invalid @enderror rounded-lg"
						required
						autofocus>

				@error('subject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
		</div>

		<div class="form-group-row">
			<div class="col-md-12">
				<label for="body">Your Message</label>
				<textarea name="body"
						rows="10"
						class="form-control @error('subject') is-invalid @enderror rounded-lg"
						required
						autofocus
				>{{ old('body') }}</textarea>

				@error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
		</div>

		<input type="hidden" name="recipient_id" value="{{ $ad->user_id }}">
		<input type="hidden" name="ad_id" value="{{ $ad->id }}">
		<div class="form-group row mt-4">
            <div class="col-md-12" style="left: 15px;">
                <button type="submit" class="btn btn-primary rounded">Send</button>
            </div>
        </div>
	</form>
</div>
