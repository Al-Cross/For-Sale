@extends ('layouts.user')

@section ('title', 'Messages')

@section ('content')
	<div class="site-section bg-secondary">
		<div class="container">
			<div class="button-container mb-5 border-bottom">
                <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
                <a href="#profile" class="draw-outline draw-outline--tandem"> Messages</a>
                <a href="#contact" class="draw-outline draw-outline--tandem">Settings</a>
            </div>

            <tabs>
                <tab name="Inbox" :selected="true">
                    @forelse($inbox as $message)
                        <div class="flex p-2 border-success bg-white rounded mb-4 mt-2">
                            <div class="d-flex justify-content-between align-items-end border-bottom rounded mb-4 card-header">
                                <h6 class="font-weight-bold">{{ $message->message->creator->name }} reached out to you about
                                    <a href="{{ $message->message->ad->path() }}">{{ $message->message->ad->title }}</a> {{ $message->created_at->diffForHumans() }}
                                </h6>
                                <form action="{{ route('archive', $message->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm mt-3 rounded">
                                        <i class="fas fa-file-archive"></i> Archive
                                    </button>
                                </form>
                                <form action="{{ route('delete-from-inbox', $message->message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-3 rounded">Delete</button>
                                </form>
                            </div>
                            <h6 class="font-weight-bold mb-4">{{ $message->message->subject }}</h6>
                            <p class="text-xs">{{ $message->message->body }}</p>
                            <div class="border-top mb-4">
                                <reply :parentmessage="{{ json_encode($message->message) }}" class="mt-3"></reply>
                            </div>
                        </div>
                    @empty
                        <h3 class="mt-5">No messages yet.</h3>
                    @endforelse
                </tab>

                <tab name="Sent">
                    @forelse($sent as $message)
                        <div class="flex p-2 border-success bg-white rounded mb-4 mt-2">
                            <div class="d-flex justify-content-between align-items-end border-bottom rounded mb-4 card-header">
                                <h6 class="font-weight-bold">Sent to {{ $message->message->recipient->name }} about
                                    <a href="{{ $message->message->ad->path() }}">{{ $message->message->ad->title }}</a> {{ $message->created_at->diffForHumans() }}
                                </h6>
                                <form action="{{ route('archive', $message->message->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm mt-3 rounded">
                                        <i class="fas fa-file-archive"></i> Archive
                                    </button>
                                </form>
                                <form action="{{ route('delete-from-sent', $message->message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-3 rounded">Delete</button>
                                </form>
                            </div>
                            <h6 class="font-weight-bold mb-4">{{ $message->message->subject }}</h6>
                            <p class="text-xs">{{ $message->message->body }}</p>
                            <div class="border-top mb-4"></div>
                        </div>
                    @empty
                        <h3 class="mt-5">No outbound communication.</h3>
                    @endforelse
                </tab>

                 <tab name="Archived">
                    @forelse($archived as $message)
                        <div class="flex p-2 border-success bg-white rounded mb-4 mt-2">
                            <div class="d-flex justify-content-between align-items-end border-bottom rounded mb-4 card-header">
                                <h6 class="font-weight-bold">Sent to {{ $message->message->recipient->name }} about
                                    <a href="{{ $message->message->ad->path() }}">{{ $message->message->ad->title }}</a> {{ $message->created_at->diffForHumans() }}
                                </h6>
                                <form action="{{ route('delete-from-archived', $message->message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-3 rounded">Delete</button>
                                </form>
                            </div>
                            <h6 class="font-weight-bold mb-4">{{ $message->message->subject }}</h6>
                            <p class="text-xs">{{ $message->message->body }}</p>
                            @if($message->message->creator_id != Auth::id())
                                <div class="border-top mb-4">
                                    <reply :parentmessage="{{ json_encode($message->message) }}" class="mt-3"></reply>
                                </div>
                            @endif
                        </div>
                    @empty
                        <h3 class="mt-5">Empty archive.</h3>
                    @endforelse
                </tab>
            </tabs>
		</div>
	</div>
@endsection
