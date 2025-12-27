@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Notifications</h1>
    @forelse($notifications as $notification)
        @php
            $type = $notification->data['type'] ?? null;
            $message = $notification->data['message'] ?? 'You have a new notification.';
            $url = '#';

            if ($type === 'like' || $type === 'comment') {
                $url = route('posts.show', ['post' => $notification->data['post_id'] ?? 0]);
            } elseif ($type === 'follow') {
                $url = route('profile.show', ['user' => $notification->data['user_name'] ?? 0]);
            }
        @endphp

        <a href="{{ $url }}" style="text-decoration: none" class="alert alert-info d-block mb-2">
            {{ $message }}
            <br>
            <small>{{ $notification->created_at->diffForHumans() }}</small>
        </a>
    @empty
        <p>No notifications.</p>
    @endforelse

    {{ $notifications->links() }}
</div>
@endsection
