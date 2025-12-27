@extends('layouts.app')

@section('content')

<div class="container">
    

    <div class="filter-tabs">
        <a href="?filter=recent" class="{{ request('filter', 'recent') == 'recent' ? 'active' : '' }}">Recent</a>
        <a href="?filter=popular" class="{{ request('filter') == 'popular' ? 'active' : '' }}">Popular</a>
    </div>
    <div class="row justify-content-center">

        @foreach($posts as $post)
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        @if($post->user)
                            <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : 'https://via.placeholder.com/40' }}" class="rounded-circle me-3" style="width: 40px; height: 40px;" alt="Profile Picture">
                            <a href="{{ route('profile.show', $post->user->username) }}" class="text-dark text-decoration-none">
                                <strong>{{ $post->user->username }}</strong>
                            </a>
                        @else
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" style="width: 40px; height: 40px;" alt="Profile Picture">
                            <span class="text-muted">Deleted User</span>
                        @endif
                    </div>
                    <a href="{{ route('posts.show', $post->id)}}">
                    <img src="{{ asset('storage/' . $post->imagePath) }}" class="card-img-top post-image" alt="Post Image">
                    </a>
                    <div class="card-body">
                        <div class="d-flex mb-2 align-items-center">
                            @auth
                                <form action="{{ route('likes.store', $post) }}" method="POST" class="like-form me-3" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0">
                                        <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart" id="heart-icon-{{ $post->id }}"></i>
                                    </button>
                                </form>
                            @endauth
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-link p-0">
                                <i class="far fa-comment"></i>
                            </a>
                        </div>
                        <p id="like-count-{{ $post->id }}">
                            <strong>{{ $post->likes->count() }} likes</strong>
                        </p>
                        @if($post->user)
                            <p><strong>{{ $post->user->username }}</strong> {{ $post->caption }}</p>
                        @else
                            <p>{{ $post->caption }}</p>
                        @endif
                        <a href="{{ route('posts.show', $post->id) }}" class="text-muted">
                            View all {{ $post->comments->count() }} comments
                        </a>
                        <p class="text-muted mt-1">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
