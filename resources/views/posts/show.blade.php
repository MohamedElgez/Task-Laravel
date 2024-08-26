@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</small>

    @auth
    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Post</button>
    </form>
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary mt-3">Edit Post</a>
    @endauth

    <h2 class="mt-4">Comments</h2>
    <form action="{{ url('comments') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
    </form>

    <ul class="list-group mt-4">
        @foreach($post->comments as $comment)
            <li class="list-group-item">
                <p>{{ $comment->content }}</p>
                <small>Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>
                @if ($comment->user_id === auth()->id())
                    <form action="{{ url('comments/'.$comment->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete Comment</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
