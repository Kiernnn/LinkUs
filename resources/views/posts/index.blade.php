@extends('layouts.sidebar')
@section('title', 'Home')

@section('style')
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
            <div class="post-wrapper">
                @foreach ($posts as $post)
                    <div class="post-container">
                        <div class="post-header">
                            <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                            <div class="profile-name">{{ $post->user->userName }}</div>
                            <div class="post-subtitle mb-2 small">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <!-- <small style="color:white">Posted on {{ $post->created_at->format('F j, Y') }}</small> -->
                        <div class="post-content">
                            <p class="content ml-10px">{{ $post->content }}</p>
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="post-image" alt="Post image">
                            @endif
                            <div class="post-footer">
                                <form action="{{ route( 'posts.love', $post->id ) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="love-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#fff">
                                            <path
                                                d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z" />
                                        </svg>
                                    </button>
                                </form>
                                <button>
                                    <a href="{{ route('posts.detail', $post->id) }}" class="card-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#fff">
                                            <path
                                                d="M880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                                        </svg>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end post containers -->
        </div>
    </div>
@endsection
