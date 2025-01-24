@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="profile-content p-4">
        <div class="profile-box">
            <a href="{{ route('profile.index') }}" class="profile mb-2">{{ __('Profile') }}</a>

            <!-- Profile container Start -->
            <div class="post-form-container card p-4 shadow">
                <div class="profile-section d-flex mb-0">
                    <div class="profile-info">
                        <div class="profile-name">{{ $viewingUser->userName }}</div>
                        <div class="subname d-flex">
                            <p class="firstName">{{ $viewingUser->firstName }}</p>
                            <p class="lastName">{{ $viewingUser->lastName }}</p>
                        </div>
                    </div>
                    <!-- Profile Image -->
                    @if ($viewingUser->profile && $viewingUser->profile->image)
                        <img src="{{ asset('profiles/' . $viewingUser->profile->image) }}"
                            class="profile-pic rounded-circle ms-auto" alt="Profile image" data-bs-toggle="modal"
                            data-bs-target="#profileImageModal" style="cursor: pointer;">
                    @else
                        <img src="{{ asset('images/user_default.png') }}" class="profile-pic rounded-circle ms-auto"
                            alt="Profile image" data-bs-toggle="modal" data-bs-target="#profileImageModal"
                            style="cursor: pointer;">
                    @endif

                    <!-- Bootstrap Modal for Image Popup -->
                    <div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <button style="margin-left:450px;" type="button" class="btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                    @if ($viewingUser->profile && $viewingUser->profile->image)
                                        <img src="{{ asset('profiles/' . $viewingUser->profile->image) }}" class="img-fluid"
                                            alt="Profile image">
                                    @else
                                        <img src="{{ asset('images/user_default.png') }}" class="img-fluid"
                                            alt="Profile image">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="all mb-0">
                    <div class="all-post">
                        <p class="post-text">{{ $viewingUser->posts->count() }}</p>
                        <p class="post-sub">{{ __('posts') }}</p>
                    </div>
                    <div class="all-fri">
                        {{-- <p class="fri-text">{{ $viewingUser->totalFriends() }}</p> --}}
                        <p class="fri-text">{{ $friends->count() }}</p>
                        <p class="fri-sub">{{ __('friends') }}</p>
                    </div>
                </div>
                <div class="bio mt-0 mb-0">
                    <p class="bio-text">
                        @if ($viewingUser->profile && $viewingUser->profile->about)
                            {{ $viewingUser->profile->about }}
                        @else
                            <p style="color:#fff;">
                                {{ auth()->check() && auth()->user()->id === $viewingUser->id ? 'No bio' : '' }}</p>
                        @endif
                    </p>
                </div>

                <div class="profile-footer">
                    @if (auth()->check() && auth()->user()->id === $viewingUser->id)
                        <a href="{{ route('profile.edit') }}" class="post-btn btn">{{ __('Edit Profile') }}</a>
                    @endif

                    <div class="buttons">
                        @if (auth()->check() && auth()->user()->id !== $viewingUser->id)
                            {{-- If already friends --}}
                            @if ($isFriend)
                                <button class="unfriend btn" id="unfriendBtn"
                                    onclick="handleFriendRequest('unfriend', {{ $viewingUser->id }})">{{ __('Unfriend') }}</button>
                                {{-- Friend request received --}}
                            @elseif ($friendRequestFromViewingUser)
                                <button class="accept btn" id="acceptBtn"
                                    onclick="handleFriendRequest('accept', {{ $friendRequestFromViewingUser->id }})">{{ __('Accept') }}</button>
                                <button class="decline btn" id="declineBtn"
                                    onclick="handleFriendRequest('decline', {{ $friendRequestFromViewingUser->id }})">{{ __('Decline') }}</button>

                                {{-- Friend request sent --}}
                            @elseif ($friendRequestFromAuthUser)
                                <button class="decline btn" id="cancelBtn"
                                    onclick="handleFriendRequest('cancel', {{ $viewingUser->id }})">{{ __('Cancel') }}</button>

                                {{-- No friend request, show Add Friend --}}
                            @else
                                <button class="accept btn" id="addFriendBtn"
                                    onclick="handleFriendRequest('send', {{ $viewingUser->id }})">{{ __('Add Friend') }}</button>
                            @endif
                        @endif
                    </div>

                    <div id="friendRequestMessage" style="display: none;">
                        <p class="success-message"></p>
                    </div>

                </div>
            </div>
            <!-- Profile container End -->

            <div class="sub-container">
                @if (auth()->check() && auth()->user()->id === $viewingUser->id)
                    <!-- Create container Start -->

                    <!-- Create container End -->

                    <!-- Friend container Start -->
                    @if ($viewingUser->totalFriends() === 0)
                        <div class="create-wrapperB mt-0">
                            <div class="create-form-containerB card p-4 shadow mt-2">
                                <div class="createB">
                                    <a href="{{ route('posts.create') }}" class="create-icon">
                                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" height="18px"
                                            viewBox="0 -960 960 960" width="18px" fill="#fff">
                                            <path
                                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('posts.create') }}"
                                        class="create-text mt-2">{{ __('Create Post') }}</a>
                                    <p class="sub-text text-secondary">
                                        {{ __("Say what's on your mind or share a recent highlight.") }}</p>
                                    <div class="buttons" style="display:flex;">
                                        <a href="{{ route('posts.create') }}" class="create-btn btn"
                                            type="submit">{{ __('Create') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($viewingUser->totalFriends() > 0)
                        <div class="create-wrapper mt-0">
                            <div class="create-form-container card p-4 shadow mt-2">
                                <div class="create">
                                    <a href="{{ route('posts.create') }}" class="create-icon">
                                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" height="18px"
                                            viewBox="0 -960 960 960" width="18px" fill="#fff">
                                            <path
                                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('posts.create') }}"
                                        class="create-text mt-2">{{ __('Create Post') }}</a>
                                    <p class="sub-text text-secondary">
                                        {{ __("Say what's on your mind or share a recent highlight.") }}</p>
                                    <div class="buttons" style="display:flex;">
                                        <a href="{{ route('posts.create') }}" class="create-btn btn"
                                            type="submit">{{ __('Create') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="friend-wrapper mt-0">
                            <div class="friend-form-container card p-4 shadow mt-2">
                                @if ($viewingUser->totalFriends())
                                    <div class="friend">
                                        <a href="{{ route('friends.list', $viewingUser->id) }}" class="friend-icon">
                                            <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#fff">
                                                <path
                                                    d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('friends.list', $viewingUser->id) }}" class="friend-text mt-2">
                                            {{ __('Friends') }}</a>
                                        {{-- <p class="sub-text text-secondary">
                                            {{ $viewingUser->totalFriends() }}{{ __(' friends') }}</p> --}}
                                        <p class="sub-text text-secondary">
                                            {{ $friends->count() }}{{ __(' friends') }}
                                        </p>

                                        <div class="buttons" style="display:flex;">
                                            <a href="{{ route('friends.list', $viewingUser->id) }}"
                                                class="friend-btn btn">{{ __('See all') }}</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="friend">
                                        <div class="friend-icon">
                                            <svg class="icon-btn" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#fff">
                                                <path
                                                    d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                                            </svg>
                                        </div>

                                        <p class="friend-text mt-2">{{ __('Friends') }}</p>
                                        <p class="sub-text text-secondary">
                                            {{ $viewingUser->totalFriends() }}{{ __('friends') }}</p>

                                        <div class="buttons" style="display:flex;">
                                            <a href="{{ route('friendRequests.suggestions') }}"
                                                class="friend-btn btn">{{ __('Find Friends') }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                    @endif
                    <!-- Friend container End -->
                @endif
            </div>

            <!-- Post container Start -->
            <div class="post-wrapper mt-0">
                @foreach ($posts as $post)
                    @php
                        $postProfile = $post->user->profile;
                        $hasLoved = $post->loves()->where('user_id', auth()->id())->exists();
                    @endphp
                    <div class="post-form-container card p-4 shadow mt-1">

                        <!-- Profile Section Start -->
                        <div class="post-header d-flex">
                            <img src="{{ asset($post->user->profile && $post->user->profile->image ? 'profiles/' . $post->user->profile->image : 'images/user_default.png') }}"
                                alt="Profile Picture" class="post-profile rounded-circle">
                            <div class="post-pf-name ms-0">
                                <a href="{{ route('profile.index', $post->user->id) }}"
                                    style="text-decoration: none; color:white;">{{ $post->user->userName }}
                                </a>
                            </div>
                            <div class="post-subtitle mb-2 small text-secondary">
                                {{ timeDiffInHours($post->created_at) }}
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
                                        {{-- <a href="#" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18px"
                                                viewBox="0 -960 960 960" width="18px" fill="#fff">
                                                <path
                                                    d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-82v-78q-33 0-56.5-23.5T360-320v-40L168-552q-3 18-5.5 36t-2.5 36q0 121 79.5 212T440-162Zm276-102q20-22 36-47.5t26.5-53q10.5-27.5 16-56.5t5.5-59q0-98-54.5-179T600-776v16q0 33-23.5 56.5T520-680h-80v80q0 17-11.5 28.5T400-560h-80v80h240q17 0 28.5 11.5T600-440v120h40q26 0 47 15.5t29 40.5Z" />
                                            </svg>
                                            {{ __('Edit privacy') }}
                                        </a> --}}
                                        <div class="dropdown-divider"></div> <!-- Divider for separation -->
                                        <div class="privacy-options">
                                            <a href="#" class="dropdown-item" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18px"
                                                    viewBox="0 -960 960 960" width="18px" fill="#fff">
                                                    <path
                                                        d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-82v-78q-33 0-56.5-23.5T360-320v-40L168-552q-3 18-5.5 36t-2.5 36q0 121 79.5 212T440-162Zm276-102q20-22 36-47.5t26.5-53q10.5-27.5 16-56.5t5.5-59q0-98-54.5-179T600-776v16q0 33-23.5 56.5T520-680h-80v80q0 17-11.5 28.5T400-560h-80v80h240q17 0 28.5 11.5T600-440v120h40q26 0 47 15.5t29 40.5Z" />
                                                </svg>
                                                {{ __('Edit privacy') }}
                                            </a>
                                            <div class="dropdown-menu">
                                                @foreach (\App\Enums\PostStatus::cases() as $status)
                                                    <a class="dropdown-item"
                                                        href="{{ route('posts.updatePrivacy', [$post->id, $status->value]) }}">
                                                        {{ $status->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>

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

                        </div>
                        <!-- Profile Section End -->

                        <!-- Post Content Section Start -->
                        <div class="post-content mt-1">
                            <p class="content">{{ $post->content }}</p>
                            <!-- Post Image -->
                            @if ($post->image)
                                <img src="{{ asset('posts/' . $post->image) }}" class="post-image rounded-3 mt-2"
                                    alt="Post image" data-bs-toggle="modal" data-bs-target="#postImageModal"
                                    style="cursor: pointer;">
                            @endif

                            <!-- Bootstrap Modal for Post Image Popup -->
                            <div class="modal fade" id="postImageModal" tabindex="-1"
                                aria-labelledby="postImageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            @if ($post->image)
                                                <img src="{{ asset('posts/' . $post->image) }}" class="img-fluid"
                                                    alt="Post image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="post-footer d-flex mt-1">
                                {{-- love reaction --}}
                                @if (auth()->id() !== $post->user_id)
                                    <form id="loveForm-{{ $post->id }}"
                                        action="{{ route('posts.toggleLove', $post->id) }}" method="POST"
                                        class="love-form" style="display:inline;">
                                        @csrf
                                        <button type="button" class="btn love-btn" data-post-id="{{ $post->id }}">
                                            @php
                                                $userLoved = $post->loves()->where('user_id', auth()->id())->exists();
                                            @endphp
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="{{ $userLoved ? '#ff0000' : '#fff' }}"
                                                class="bi {{ $userLoved ? 'bi-heart-fill' : 'bi-heart' }}"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="{{ $userLoved ? 'M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314' : 'm8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15' }}" />
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Love count display -->
                                    <p id="loveCount-{{ $post->id }}" class="love-count"
                                        style="{{ $post->loves->count() > 0 ? '' : 'display:none;' }}">
                                        {{ $post->loves->count() }}
                                    </p>
                                @endif

                                {{-- <!-- Button to show lovers -->
                                <button class="btn" id="showLoversButton">
                                    {{ $post->loves()->count() }} <span class="heart-icon"></span>
                                </button>

                                <!-- Popup Div -->
                                <div id="loversPopup" style="display: none; position: absolute; background-color: rgba(0, 0, 0, 0.8); color: white; width: auto; height: auto; padding: 10px; border-radius: 5px;">
                                    <div id="loversList"></div>
                                </div> --}}


                                <button class="btn">
                                    <a href="{{ route('posts.detail', $post->id) }}" class="card-link">
                                        <svg class="cmt-svg" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="#fff" class="bi bi-chat-right" viewBox="0 0 16 16">
                                            <path
                                                d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
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
                        <!-- Post Content Section End -->
                    </div>
                @endforeach
            </div>
            <!-- Post container End -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        function handleFriendRequest(action, userId) {
            let url = '';

            switch (action) {
                case 'send':
                    url = "{{ route('friendRequests.send') }}";
                    break;
                case 'accept':
                    url = "{{ route('friendRequests.accept') }}";
                    break;
                case 'decline':
                    url = "{{ route('friendRequests.decline', ':id') }}".replace(':id', userId);
                    break;
                case 'cancel':
                    url = "{{ route('friendRequests.cancel', ':id') }}".replace(':id', userId);
                    break;
                case 'unfriend':
                    url = "{{ route('friends.unfriend', ':id') }}".replace(':id', userId);
                    break;
            }

            $.ajax({
                url: url,
                type: action === 'send' || action === 'accept' ? 'POST' : 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    receiverId: userId,
                    reqId: userId
                },
                success: function(response) {
                    // $('#friendRequestMessage').fadeIn().find('.success-message').text(response.message);
                    // setTimeout(function() {
                    //     $('#friendRequestMessage').fadeOut();
                    // }, 3000);
                    // Reload or change button text based on the action
                    updateFriendshipButtons(action);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    // alert('An error occurred.');
                }
            });
        }

        function updateFriendshipButtons(action) {
            let buttonContainer = $('.buttons');

            switch (action) {
                case 'send':
                    buttonContainer.html(
                        '<button class="decline btn" id="cancelBtn" onclick="handleFriendRequest(\'cancel\', {{ $viewingUser->id }})">{{ __('Cancel') }}</button>'
                    );
                    break;
                case 'accept':
                    buttonContainer.html(
                        '<button class="unfriend btn" id="unfriendBtn" onclick="handleFriendRequest(\'unfriend\', {{ $viewingUser->id }})">{{ __('Unfriend') }}</button>'
                    );
                    break;
                case 'cancel':
                case 'decline':
                    buttonContainer.html(
                        '<button class="accept btn" id="addFriendBtn" onclick="handleFriendRequest(\'send\', {{ $viewingUser->id }})">{{ __('Add Friend') }}</button>'
                    );
                    break;
                case 'unfriend':
                    buttonContainer.html(
                        '<button class="accept btn" id="addFriendBtn" onclick="handleFriendRequest(\'send\', {{ $viewingUser->id }})">{{ __('Add Friend') }}</button>'
                    );
                    break;
            }
        }

        document.querySelectorAll('.love-btn').forEach(button => {
            button.addEventListener('click', function() {
                let postId = this.getAttribute('data-post-id');
                let form = document.getElementById(`loveForm-${postId}`);
                let formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the heart icon based on whether the user has loved or unloved
                            let svg = this.querySelector('svg');
                            if (data.hasLoved) {
                                svg.classList.remove('bi-heart');
                                svg.classList.add('bi-heart-fill');
                                svg.setAttribute('fill', '#ff0000'); // Set fill color for loved
                                svg.querySelector('path').setAttribute('d',
                                    'M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'
                                );
                            } else {
                                svg.classList.remove('bi-heart-fill');
                                svg.classList.add('bi-heart');
                                svg.setAttribute('fill', '#fff'); // Set fill color for unloved
                                svg.querySelector('path').setAttribute('d',
                                    'm8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'
                                );
                            }

                            // Update the love count dynamically
                            let loveCountElement = document.querySelector(`#loveCount-${postId}`);
                            if (data.loveCount > 0) {
                                loveCountElement.textContent = data.loveCount;
                                loveCountElement.style.display = 'inline';
                            } else {
                                loveCountElement.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
