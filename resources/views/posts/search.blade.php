@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search Results</h1>

        @if ($posts->isEmpty())
            <p>No posts found.</p>
        @else
            @foreach ($posts as $post)
                <div class="post">
                    <h2>{{ $post->title }}</h2>
                    <p>{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ asset('storage/posts/' . $post->image) }}" alt="Post Image">
                    @endif
                </div>
            @endforeach
        @endif
    </div>
@endsection
