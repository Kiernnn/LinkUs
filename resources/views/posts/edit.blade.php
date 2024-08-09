@extends('layouts.sidebar')
@section('title', 'Home')


@section('content')
    <div class="container">
        <!-- back button -->
        <a href="{{ route('posts.detail', $post->id) }}" class="btn btn-primary">Back</a>
        <h1>Edit Post</h1>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="public" {{ $post->status == 'public' ? 'selected' : '' }}>Public</option>
                    <option value="friends" {{ $post->status == 'friends' ? 'selected' : '' }}>Friends</option>
                    <option value="me" {{ $post->status == 'me' ? 'selected' : '' }}>Me</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" name="image" id="image" class="form-control-file">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="max-width: 100px;">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
