<div class="card my-4">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#" >{{ $reply->owner->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}...
            </h5>
            <div>
                <form method="POST" action="{{ route('favorite_reply', $reply->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ?  'disabled' : ''}}>
                        {{ $reply->favorites()->count() }} {{ Str::plural('Favorite', $reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
