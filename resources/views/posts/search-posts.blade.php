{{-- Layout --}}
@extends('layouts.sidebar')
@section('title', 'Search Users')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/post_index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

{{-- Section for Search Users --}}
@section('content')
    <div class="container-fluid scrollable-container">
        <div class="home-content p-4">
            <!-- Search Tab Start -->
            <form action="{{ route('posts.search') }}" method="POST" style="display: flex;">
                <div class="justify-content-center container">
                    @csrf
                    <input type="text" name="search" class="input" placeholder="Search"
                        value="{{ old('search', $keyword ?? '') }}">
                    <button class="search__btn" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                            <path
                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"
                                fill="#efeff1"></path>
                        </svg>
                    </button>
                </div>
            </form>
            <!-- Search Tab End -->

            <div class="post-wrapper">
                <div class="friends-container mb-1 mt-3">
                    <div class="friends mb-3">Search Result for " {{ $keyword }} "</div>
                    <div class="title-links">
                        <a href="{{ route('posts.searchUsers', $keyword) }}"
                            class="links {{ Request::is('posts/search-users') ? 'active' : '' }}">{{ __('Users') }}</a>
                        <a href="{{ route('posts.searchPosts', $keyword) }}"
                            class="links {{ Request::is('posts/search-posts') ? 'active' : '' }}">{{ __('Posts') }}</a>
                    </div>
                    <hr class="hr">
                    {{-- search posts --}}
                    @if ($posts->isEmpty())
                        <p class="friends">Not found.</p>
                    @else
                        @foreach ($posts as $post)
                            @php
                                $postProfile = $post->user->profile;
                                $hasLoved = $post->loves()->where('user_id', auth()->id())->exists();
                            @endphp
                            <a href="{{ route('profile.show', $post->user->id) }}" class="post-header d-flex">
                                @if ($postProfile && $postProfile->image && file_exists(public_path('profiles/' . $postProfile->image)))
                                    <img src="{{ asset('profiles/' . $postProfile->image) }}" alt="Profile Picture"
                                        class="profile-pic me-3">
                                @else
                                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture"
                                        class="profile-pic">
                                @endif
                                <div class="profile-name">{{ $post->user->userName }}</div>
                                <div class="post-subtitle mb-2 small">{{ timeDiffInHours($post->created_at) }}
                                </div>

                                <div class="privacy">
                                    @if ($post->status === 'public')
                                        <svg class="status-svg" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#808080">
                                            <path
                                                d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-82v-78q-33 0-56.5-23.5T360-320v-40L168-552q-3 18-5.5 36t-2.5 36q0 121 79.5 212T440-162Zm276-102q20-22 36-47.5t26.5-53q10.5-27.5 16-56.5t5.5-59q0-98-54.5-179T600-776v16q0 33-23.5 56.5T520-680h-80v80q0 17-11.5 28.5T400-560h-80v80h240q17 0 28.5 11.5T600-440v120h40q26 0 47 15.5t29 40.5Z" />
                                        </svg>
                                    @elseif($post->status === 'friends')
                                        <svg class="status-svg" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#808080">
                                            <path
                                                d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                                        </svg>
                                    @elseif($post->status === 'me')
                                        <svg class="status-svg" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#808080">
                                            <path
                                                d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Dropdown Section Start -->
                                @if (auth()->check() && auth()->user()->id === $post->user_id)
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                                width="24px" fill="#ffffff">
                                                <path
                                                    d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z" />
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18px"
                                                    viewBox="0 -960 960 960" width="18px" fill="#fff">
                                                    <path
                                                        d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                </svg>
                                                {{ __('Edit post') }}
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18px"
                                                    viewBox="0 -960 960 960" width="18px" fill="#fff">
                                                    <path
                                                        d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-82v-78q-33 0-56.5-23.5T360-320v-40L168-552q-3 18-5.5 36t-2.5 36q0 121 79.5 212T440-162Zm276-102q20-22 36-47.5t26.5-53q10.5-27.5 16-56.5t5.5-59q0-98-54.5-179T600-776v16q0 33-23.5 56.5T520-680h-80v80q0 17-11.5 28.5T400-560h-80v80h240q17 0 28.5 11.5T600-440v120h40q26 0 47 15.5t29 40.5Z" />
                                                </svg>
                                                {{ __('Edit privacy') }}
                                            </a>

                                            <!-- Form to delete post -->
                                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="18px"
                                                        viewBox="0 -960 960 960" width="18px" fill="#c31818">
                                                        <path
                                                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                    </svg>
                                                    {{ __('Delete post') }}
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endif
                                <!-- Dropdown Section End -->
                            </a>

                            <div class="post-content mt-1">
                                <p class="content ml-10px">{{ $post->content }}</p>
                                @if ($post->image)
                                    <img src="{{ asset('posts/' . $post->image) }}" class="post-image" alt="Post image">
                                @endif
                                <div class="post-footer d-flex mt-1">
                                    <form action="{{ route('posts.toggleLove', $post->id) }}" method="POST"
                                        class="me-0" style="display:inline;">
                                        @csrf
                                        <button class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                                fill="{{ $hasLoved ? '#dc3545' : '#fff' }}"
                                                class="bi {{ $hasLoved ? 'bi-heart-fill' : 'bi-heart' }}"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="{{ $hasLoved ? 'M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314' : 'm8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15' }}" />
                                            </svg>
                                        </button>
                                    </form>
                                    @if ($post->loves->count())
                                        <p class="love-count">{{ $post->loves->count() }}</p>
                                    @else
                                        <p hidden></p>
                                    @endif
                                    <button class="btn">
                                        <a href="{{ route('posts.detail', $post->id) }}" class="card-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#fff">
                                                <path
                                                    d="M880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                                            </svg>
                                        </a>
                                    </button>
                                    @if ($post->comments->count())
                                        <p class="cmt-count">{{ $post->comments->count() }}</p>
                                    @else
                                        <p hidden></p>
                                    @endif
                                </div>
                            </div>
                            <hr class="hr">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
