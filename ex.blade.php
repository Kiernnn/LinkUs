@extends('layouts.sidebar')
@section('title', 'Home')

@section('style')
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="scrollable-container">
        <div class="home-content p-4">
            <!-- start search tab -->
            <div class="container">
                <input type="text" name="text" class="input" placeholder=" Search">
                <button class="search__btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                        <path
                            d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"
                            fill="#efeff1"></path>
                    </svg>
                </button>
            </div>
            <!-- end search tab -->

            <!-- start post containers -->
            @forelse ($posts as $post)
                <div class="post-container">
                    <div class="post-header">
                        <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                        <div class="profile-name" style="color:white;">{{ $post->user->userName }}</div>
                    </div>

                    <!-- Created Time -->
                    <div class="post-subtitle mb-2 small" style="color:white;">
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                    <div class="post-content">
                        <p class="content ml-10px" style="color:white;">{{ $post->content }}</p>
                    </div>
                    <div class="post-image">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="width: 300px; height: 300px; color:white;">
                        @endif
                    </div>

                    <!-- Like, comment section -->
                    <div class="footer-info">
                        <button>Like</button>
                        <button>
                            <a href="{{ route('posts.detail', $post->id) }}" class="card-link" style="text-decoration:none; color:white;">
                                Comment
                            </a>
                        </button>
                        <button>Share</button>
                    </div>
                    
                    <!-- New Comment -->
                    <div class="post-footer">
                        <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                        <div class="profile-name" style="color:white;">{{ auth()->user()->userName }}</div>
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="comment-box">
                                <input type="text" name="content" placeholder="Add a comment...">
                                <button>Comment</button>
                            </div>
                        </form>
                    </div>

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger" style="width:200px; height:40px; padding:5px 5px 5px 5px; text-decoration:none; margin-left:100px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <span>{{ "Write something!" }}</span>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <!-- No posts message -->
                <p>Add friends to see more posts.</p>
            @endforelse

            <!-- Show message if there are less than or equal to 3 posts -->
            @if ($posts->count() <= 3 && $posts->count() > 0)
                <p>Add friends to see more posts.</p>
            @endif
            <!-- end post containers -->
        </div>
    </div>
@endsection
