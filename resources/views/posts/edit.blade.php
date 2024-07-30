@extends('layouts.app')
@extends('layouts.sidebar')


@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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
            <!-- <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" id="caption" class="form-control" value="{{ $post->caption }}">
            </div> -->
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control-file">
                @if($post->photo)
                    <img src="{{ asset('storage/' . $post->photo) }}" alt="Post photo" style="max-width: 100px;">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
