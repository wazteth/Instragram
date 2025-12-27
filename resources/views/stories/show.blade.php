@extends('layouts.app')

@section('content')
    <div class="container mt-5 text-center">
        <img src="{{ asset('storage/' . $story->image_path) }}" class="img-fluid mb-3" style="max-height: 500px;">
        <h5>{{ $story->user->username }}</h5>
    </div>
@endsection