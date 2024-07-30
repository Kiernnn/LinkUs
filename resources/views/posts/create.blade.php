@extends('layouts.sidebar')
@section('title', 'Create New Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <div class="post-form-container">
            <h2>New Post</h2>
            <form action="{{ route('posts.store') }}" method="POST" class="post-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="public">Public</option>
                        <option value="friends">Friends</option>
                        <option value="me">Me</option>
                    </select>
                </div>
                <textarea name="content" placeholder="What's on your mind?"></textarea>
                <div class="form-actions">
                    <input class="postImg" name="photo" id="postImg" type="file">
                    <button class="post" type="submit">{{ __('Post') }}</button>
                </div>
            </form>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
@endsection
