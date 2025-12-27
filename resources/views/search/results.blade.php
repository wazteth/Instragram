@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Search results for "{{ $query }}"</h3>

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4 mb-3">
                    <a style="text-decoration: none" href="{{ route('profile.show', $user->username) }}">
                        <div class="card p-3">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/100' }}"
                                 class="rounded-circle mb-2" style="width: 50px; height: 50px;">
                            <div><strong>{{ $user->username }}</strong></div>
                            <p>{{ $user->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
