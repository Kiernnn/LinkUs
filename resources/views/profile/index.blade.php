@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="profile-content p-4">
        <div class="profile-box">
            <h5 class="profile">{{ __('Profile') }}</h5>
            <div class="post-form-container">
                <div class="profile-section">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->userName }}</div>
                        <div class="subname">
                            <p class="firstName">{{ auth()->user()->firstName }}</p>
                            <p class="lastName">{{ auth()->user()->lastName }}</p>
                        </div>
                        <div class="bio">
                            <p class="bio-text">
                                @if (auth()->user()->profile)
                                    {{ auth()->user()->profile->about }}
                                @else
                                    {{ __('No bio yet') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @if (auth()->user()->profile && auth()->user()->profile->image)
                        <img src="{{ asset('profiles/' . auth()->user()->profile->image) }}" class="profile-pic" alt="Profile image">
                    @else
                        <img src="{{ asset('images/user_default.png') }}" class="profile-pic" alt="Profile image">
                    @endif
                </div>

                <div class="profile-footer">
                    <a href="{{ route('profile.edit') }}"
                        class="post-btn btn">{{ __('Edit Profile') }}</a>
                </div>
            </div>

            <!-- Post container Start -->
            <div class="post-wrapper mt-2">
                @foreach ($posts as $post)
                    <div class="post-form-container mb-2">

                        <!-- Profile Section Start -->
                        <div class="post-header">
                            @if (auth()->user()->profile->image)
                                <img src="{{ asset('profiles/' . auth()->user()->profile->image) }}" alt="Profile Picture"
                                    class="post-profile">
                            @else
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture"
                                    class="post-profile">
                            @endif
                            <div class="post-pf-name">{{ $post->user->userName }}</div>
                            <div class="post-subtitle mb-2 small">
                                {{ timeDiffInHours($post->created_at) }}
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
                                    <div class="dropdown-menu dropdown-menu-end text-bg-dark">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item text-bg-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960"
                                                width="18px" fill="#fff">
                                                <path
                                                    d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                            </svg>
                                            {{ __('Edit post') }}
                                        </a>
                                        <a href="#" class="dropdown-item text-bg-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960"
                                                width="18px" fill="#fff">
                                                <path
                                                    d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-82v-78q-33 0-56.5-23.5T360-320v-40L168-552q-3 18-5.5 36t-2.5 36q0 121 79.5 212T440-162Zm276-102q20-22 36-47.5t26.5-53q10.5-27.5 16-56.5t5.5-59q0-98-54.5-179T600-776v16q0 33-23.5 56.5T520-680h-80v80q0 17-11.5 28.5T400-560h-80v80h240q17 0 28.5 11.5T600-440v120h40q26 0 47 15.5t29 40.5Z" />
                                            </svg>
                                            {{ __('Edit privacy') }}
                                        </a>
                                            
                                        <!-- Form to delete post -->
                                        <form  class="dropdown-item text-bg-dark" method="POST" action="{{ route('posts.destroy', $post->id) }}" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-bg-dark">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960"
                                                    width="18px" fill="#c31818">
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

                        </div>
                        <!-- Profile Section End -->

                        <!-- Post Content Section Start -->
                        <div class="post-content">
                            <p class="content ml-10px">{{ $post->content }}</p>
                            @if ($post->image)
                                <img src="{{ asset('posts/' . $post->image) }}" class="post-image" alt="Post image">
                            @endif
                            <div class="post-footer">
                                <form style="display:inline;">
                                    <button>
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
                        <!-- Post Content Section End -->
                    </div>
                @endforeach
            </div>
            <!-- Post container End -->
        </div>
    </div>
@endsection
