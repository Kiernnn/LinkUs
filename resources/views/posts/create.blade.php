@extends('layouts.sidebar')
@section('title', 'Create New Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <h5 class="new-post">{{ __(' Create New Post') }}</h5>
        <div class="post-form-container">
            <div class="profile-section">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                <div class="profile-name">{{ auth()->user()->userName }}</div>
            </div>
            <form action="{{ route('posts.store') }}" method="POST" class="post-form" enctype="multipart/form-data">
                @csrf
                <textarea name="content" placeholder="What's on your mind?" class="form-control"></textarea>
                <div class="form-actions d-flex justify-content-between align-items-center mt-2">
                    <label for="file-input" class="attachment-btn btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: #fff;transform: ;msFilter:;">
                            <path d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z">
                            </path>
                            <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                        </svg>
                    </label>
                    <input type="file" id="file-input" name="image" class="file-input">
                </div>
                <div class="image-preview mt-2">
                    <img class="preview-img" id="preview-img" src="{{ asset('images/user_default.png') }}"
                        alt="Image Preview">
                </div>
                <div class="form-actions d-flex justify-content-between align-items-center mt-2">
                    <div class="privacy-options">
                        <select name="privacy" class="form-select">
                            <option value="public" selected>{{ __('Public') }}</option>
                            <option value="friends">{{ __('Friends') }}</option>
                            <option value="only-me">{{ __('Only Me') }}</option>
                        </select>
                    </div>
                    <button class="post-btn btn" type="submit">{{ __('Post') }}</button>
                </div>
            </form>
            @if (session('error'))
                <div class="alert alert-danger mt-2">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    
@endsection
