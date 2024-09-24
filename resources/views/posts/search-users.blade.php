{{-- Layout --}}
@extends('layouts.sidebar')
@section('title', 'Search Users')

@section('style')
   <link rel="stylesheet" href="{{ asset('css/post_index.css') }}">
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
                    <div class="friends-container mb-3 mt-3">
                        <div class="friends mb-3">Search Result for " {{ $keyword }} "</div>
                        <div class="title-links">
                            <a href="{{ route('posts.searchUsers', $keyword)}}"
                                class="links {{ Request::is('posts/search-users') ? 'active' : '' }}">{{ __('Users') }}</a>
                            <a href="{{ route('posts.searchPosts', $keyword) }}" class="links {{ Request::is('posts/search-posts') ? 'active' : '' }}">{{ __('Posts') }}</a>
                        </div>
                    </div>
                <div class="scroll-search">
                    @if ($users->isEmpty())
                        <p class="friends">Not found.</p>
                    @else
                        <div class="suggest-form-container mb-3">
                            <div class="search-profile mb-3">
                                @foreach ($users as $user)
                                    @php
                                        $postProfile = $user->profile;
                                    @endphp
                                    <div class="request-container mb-2">
                                        <a href="{{ route('profile.show', $user->id) }}" class="searchProfile mb-0">
                                            @if ($postProfile && $postProfile->image && file_exists(public_path('profiles/' . $postProfile->image)))
                                                <img src="{{ asset('profiles/' . $postProfile->image) }}"
                                                    alt="Profile Picture" class="profile-pic me-3">
                                            @else
                                                <img src="{{ asset('images/user_default.png') }}"
                                                    alt="Profile Picture" class="profile-pic">
                                            @endif
                                            <div class="profile-info mb-0">
                                                <div class="profile-name">{{ $user->userName }}</div>
                                                <div id="successMessage{{ $user->id }}" class="add-fri"
                                                    style="display: none; color: #808080; font-weight: bold;"></div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
