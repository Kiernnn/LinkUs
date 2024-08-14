@extends('layouts.sidebar')
@section('title', 'Edit Comment')


@section('content')
    <div class="container">
        <!-- back button -->
<<<<<<< HEAD
        <a href="{{ route('posts.detail') }}" class="btn btn-primary" style="background:white; color:black;">Back</a>
=======
        <a href="{{ route('posts.detail') }}" class="btn btn-primary" >Back</a>
>>>>>>> ed30af3091e2c22f989fc419b1d6f56ce9483b97
        <h1>Edit Comment</h1>

        <form action="{{ route('comments.update', $comment ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <textarea name="content" id="content" class="form-control" required>{{ $comment->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
