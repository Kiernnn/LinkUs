@extends('layouts.sidebar')
@section('title', 'LinkUs')

@section('style')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <div class="post-form-container">
            <h2>New Post</h2>
            <form action="#" method="post" class="post-form">
                <textarea name="postContent" placeholder="What's on your mind?" required></textarea>
                <div class="form-actions">
                    <input class="postImg" name="post" id="postImg" type="file">
                    <button class="post" type="submit">{{ __('Post') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
