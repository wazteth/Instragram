@extends('layouts.app')

@section('content')
    
<div class="container">
    <div class="row">
        
        <div class="profile-pic-wrapper" style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; background: #f0f0f0;">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/150' }}"
                style="width: 100%; height: 100%; object-fit: contain;">
        </div>

        <div class="col-md-9">
            <div class="d-flex align-items-center">
                <h1> {{ $user->username }}</h1>
                @if(auth()->id() === $user->id)
                    <a href="{{ route('profile.edit', ['user' => Auth::user()->username]) }}" class="btn btn-outline-secondary ms-4">Edit Profile</a>
                @endif
            </div>
            <div class="d-flex mt-3 align-items-center">
                @if(auth()->check() && auth()->id() !== $user->id)
                    <div id="follow-container">
                        @if($alreadyFollowing)
                            <form method="POST" action="{{ route('unfollow', $user) }}" class="follow-form" data-user-id="{{ $user->id }}" data-action="unfollow">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-1 py-1 fs-6">Unfollow</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $user) }}" class="follow-form" data-user-id="{{ $user->id }}" data-action="follow">
                                @csrf
                                <button type="submit" class="btn btn-primary px-1 py-1 fs-6">Follow</button>
                            </form>
                        @endif
                    </div>
                @endif
                <div class="ms-4 me-4"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="me-4"><strong id="follower-count">{{ $user->followers()->count() }}</strong> followers</div>
                <div><strong>{{ $user->following()->count() }}</strong> following</div>
            </div>
            <div class="mt-3">
                <h5>{{ $user->name }}</h5>
                <p>{{ $user->bio }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        @foreach($user->posts as $post)
            <div class="col-md-4 mb-4">
                <a href="{{ route('posts.show', $post->id)}}">
                    <img src="{{ asset('storage/' . $post->imagePath)}}" class="w-100">
                </a>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.querySelectorAll('.follow-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const userId = this.dataset.userId;
            const action = this.dataset.action;
            const method = action === 'follow' ? 'POST' : 'DELETE';
            const url = this.action;
            const token = this.querySelector('[name="_token"]').value;

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: method === 'POST' ? JSON.stringify({}) : null,
            });

            if (response.ok) {
                const data = await response.json();

                const isFollowing = action === 'follow';
                const newAction = isFollowing ? 'unfollow' : 'follow';
                const newBtnClass = isFollowing ? 'btn-danger' : 'btn-primary';
                const newBtnText = isFollowing ? 'Unfollow' : 'Follow';

                const newForm = `
                    <form method="POST" action="${isFollowing ? `{{ route('unfollow', $user) }}` : `{{ route('follow', $user) }}`}" class="follow-form" data-user-id="${userId}" data-action="${newAction}">
                        <input type="hidden" name="_token" value="${token}">
                        ${isFollowing ? '<input type="hidden" name="_method" value="DELETE">' : ''}
                        <button type="submit" class="btn ${newBtnClass} px-1 py-1 fs-6">${newBtnText}</button>
                    </form>
                `;

                document.getElementById('follow-container').innerHTML = newForm;
                document.getElementById('follower-count').textContent = data.followerCount;

                document.querySelector('.follow-form').addEventListener('submit', arguments.callee);
            }
        });
    });
</script>
@endsection
