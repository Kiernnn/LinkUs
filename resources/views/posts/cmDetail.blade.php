@extends('layouts.sidebar')
@section('title', 'Edit Comment')


@section('content')
    <div class="container">
        <!-- back button -->
        <a href="{{ route('posts.detail') }}" class="btn btn-primary" style="background:white; color:black;">Back</a>
        <h1>Edit Comment</h1>

        <form action="{{ route('comments.update', $comment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <textarea name="content" id="content" class="form-control" required>{{ $comment->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
