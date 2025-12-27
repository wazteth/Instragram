@extends('layouts.app')

@section('content')

<div class="container">
     <!-- Stories Preview Row -->
    <div class="row mb-4">
        <div class="col">
            <h5 class="mb-2">Stories</h5>
            <div class="d-flex overflow-auto">
                @foreach($stories as $story)
                    <a href="{{ route('stories.show', $story->id) }}">
                        <img src="{{ asset('storage/' . $story->image_path) }}" alt="story" class="story-preview">
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Post or Story</div>

                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data" id="upload-form">
                    @csrf

                        <div class="mb-3">
                            <label for="caption" class="form-label">Caption</label>
                            <textarea id="caption" class="form-control @error('caption') is-invalid @enderror" name="caption" rows="3"></textarea>
                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control image-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <img src="#" alt="Image Preview" class="image-preview img-fluid rounded" style="display:none; max-height: 200px;">
                        </div>
                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit_type" value="post">
                            Post</button>
                            <button type="submit" class="btn btn-instragram-story" name="submit_type" value="story">
                            Story</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('upload-form').addEventListener('submit', function(e) {
    const type = e.submitter.value;
    if (type === 'story') {
        this.action = "{{ route('stories.store') }}";
    } else {
        this.action = "{{ route('posts.store') }}";
    }
});

document.querySelector('.image-input').addEventListener('change', function (e) {
    const preview = document.querySelector('.image-preview');
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
