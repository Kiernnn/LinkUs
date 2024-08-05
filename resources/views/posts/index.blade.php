@extends('layouts.sidebar')
@section('title', 'Home')

@section('style')
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post_index.css') }}" rel="stylesheet">
    <script src="{{ asset('js/post_index.js')}}"></script>
@endsection

@section('content')
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
        <div class="post-wrapper">
            @foreach ($posts as $post)
            <div class="post-container">
                <div class="post-actions">
                    <div class="actions">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('posts.delete', $post->id) }}" method="POST" class="btn">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                
                <div class="post-header">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                <div class="profile-name" style="color:white;">{{ auth()->user()->userName }}</div>
                </div>
                <div class="post-subtitle mb-2 small" style="color:white;">
                    {{ $post->created_at->diffForHumans() }}
                </div>
                <p class="content ml-10px" style="color:white;">{{ $post->content }}</p>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="max-width:100%; color:white;">

                @endif
                <div class="footer-info">
                <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            style="fill: #fff;transform: ;msFilter:;"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                        </svg>
                    </button>
                    <button>
                        <a href="{{ route('posts.detail', $post->id) }}" class="card-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            style="fill: #fff;transform: ;msFilter:;"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9l.3-.5z" />
                        </svg>
                    </a>
                    </button>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            style="fill: #fff;transform: ;msFilter:;">
                            <path
                                d="M11 7.05V4a1 1 0 0 0-1-1 1 1 0 0 0-.7.29l-7 7a1 1 0 0 0 0 1.42l7 7A1 1 0 0 0 11 18v-3.1h.85a10.89 10.89 0 0 1 8.36 3.72 1 1 0 0 0 1.11.35A1 1 0 0 0 22 18c0-9.12-8.08-10.68-11-10.95zm.85 5.83a14.74 14.74 0 0 0-2 .13A1 1 0 0 0 9 14v1.59L4.42 11 9 6.41V8a1 1 0 0 0 1 1c.91 0 8.11.2 9.67 6.43a13.07 13.07 0 0 0-7.82-2.55z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="post-footer">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                <div class="profile-name" style="color:white;">{{ auth()->user()->userName }}</div>
                    <div class="comment-box">
                        <input type="text" placeholder="Add a comment...">
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
        <!-- end post containers -->
    </div>
@endsection
