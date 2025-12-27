@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img src="{{ asset('storage/' . $post->imagePath) }}" class="w-100 post-image" data-bs-toggle="modal" data-bs-target="#imageModal" alt="Post Image">
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center mb-3">
                @if($post->user)
                    <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : 'https://via.placeholder.com/40' }}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                    <a href="{{ route('profile.show', $post->user->username) }}" class="text-dark text-decoration-none">
                        <strong>{{ $post->user->username }}</strong>
                    </a>
                
                @if(auth()->id() === $post->user_id)
                    <div class="dropdown ms-auto">
                        <button class="btn btn-link text-dark" type="button" id="postOptions" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="postOptions">
                            <li>
                                <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">Edit</a>
                            </li>
                            <li>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
                @else
                    <img src="https://via.placeholder.com/40" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                    <span class="text-muted">Deleted User</span>
                @endif
            </div>
            @if($post->user)
                <p><strong> {{ $post->user->username }}</strong> {{ $post->caption }}</p>
            @else
                <p> {{ $post->caption }}</p>
            @endif
            <hr>

            <div class="d-flex mb-2">
                 <form action="{{ route('likes.store', $post) }}" 
                      method="POST" 
                      class="ajax-like-form" 
                      data-post-id="{{ $post->id }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 me-2">
                        <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}" 
                           id="like-icon-{{ $post->id }}"></i>
                    </button>
                </form>
            </div>
            <p><strong id="like-count-{{ $post->id }}">{{ $post->likes->count() }} likes</strong></p>

                <p class="text-muted">{{ $post->created_at->format('F d, Y') }}</p>

                <hr>

                <div class="comments-section" style="max-height: 300px; overflow-y: auto;">
                    @foreach($post->comments as $comment)
                        <div class="d-flex mb-2">
                            @if($comment->user)
                                <strong class="me-2"> {{ $comment->user->username }}</strong>
                            @else
                                <strong class="me-2">Deleted User</strong>
                            @endif
                            <p class="mb-0">{{ $comment->comment_text }}</p>

                            @if(auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
            </div>

            <hr>

            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="comment_text" class="form-control" placeholder="Add a comment..." required>
                    <button type="submit" class="btn btn-outline-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for full image view -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0">
                <img src="{{ asset('storage/' . $post->imagePath) }}" class="img-fluid w-100 h-auto" style="max-height: 90vh; object-fit: contain;"alt="Full Image">
            </div>
        </div>
    </div>
</div>

<script>
     document.querySelectorAll('.ajax-like-form').forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const postId = form.getAttribute('data-post-id');
            const icon = document.getElementById('like-icon-' + postId);
            const countEl = document.getElementById('like-count-' + postId);
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST', // always POST for toggling
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            if (response.ok) {
                const data = await response.json();
                icon.className = data.liked ? 'fas fa-heart text-danger' : 'far fa-heart';
                countEl.textContent = `${data.like_count} likes`;
            }
        });
    });

    //Image modal viewer
    const postImage = document.querySelector('.post-image');
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');

    if (postImage) {
        postImage.addEventListener('click', () => {
            modalImage.src = postImage.src;
            modal.show();
        });
    }
</script>

@endsection