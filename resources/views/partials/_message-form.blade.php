<div id="message-form" class="card mt-5 bg-light">
	<form action="{{ route('send') }}" method="POST">
		@csrf

		<div class="form-group-row">
			<div class="col-md-12">
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
