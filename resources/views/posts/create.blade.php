@extends('layouts.sidebar')
@section('title', 'Create New Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <h5>New Post</h5>
        <div class="post-form-container">
            <div class="profile-section">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                <div class="profile-name">{{ auth()->user()->userName }}</div>
            </div>
            <form action="{{ route('posts.store') }}" method="POST" class="post-form" enctype="multipart/form-data">
                @csrf
                <textarea name="content" placeholder="What's on your mind?"></textarea>
                <div class="form-actions">
                    <label for="file-input" class="attachment-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: #fff;transform: ;msFilter:;">
                            <path
                                d="M20 2H8c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM8 16V4h12l.002 12H8z">
                            </path>
                            <path d="M4 8H2v12c0 1.103.897 2 2 2h12v-2H4V8z"></path>
                            <path d="m12 12-1-1-2 3h10l-4-6z"></path>
                        </svg>
                    </label>
                    <input type="file" id="file-input" name="file" class="file-input">
                </div>
                <div class="form-actions">
                    <div class="privacy-options">
                        <select name="privacy">
                            <option value="public" selected>Public</option>
                            <option value="friends">Friends</option>
                            <option value="only-me">Only Me</option>
                        </select>
                    </div>
                    <button class="post-btn" type="submit">{{ __('Post') }}</button>
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
