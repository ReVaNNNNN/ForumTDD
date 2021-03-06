
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#"> {{ $thread->creator->name }} </a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                      {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form action="{{ route('add_reply_to_thread', [$thread->channel->slug, $thread->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control my-4" placeholder="Have something to say?" rows="5"></textarea>

                            <button type="submit" class="btn btn-primary my-4">Post</button>
                        </div>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was publish {{ $thread->created_at->diffForHumans() }}
                            by <a href="#">{{ $thread->creator->name }}</a>
                            and currently has {{ $thread->replies_count }} {{  Str::plural('comment', $thread->replies_count) }} comments.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
