@extends('layouts.sidebar')
@section('title', 'Comment')

@section('style')
    <link href="{{ asset('css/post_detail.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="scrollable-container p-4">

        

        <!-- Display post detail -->
        <div class="detail-content container">
            <!-- Back button -->
            <a href="javascript:history.back()" class="post-btn btn" style="margin-right: 10px;">
                {{ __('Back') }}
            </a>
            @php
                $postProfile = $post->user->profile;
                $hasLoved = $post->loves()->where('user_id', auth()->id())->exists();
            @endphp
            <div class="post-container mb-3 shadow-sm p-4 rounded-4 text-light">
                <div class="post-header d-flex mb-1">
                    @if ($postProfile && $postProfile->image && file_exists(public_path('profiles/' . $postProfile->image)))
                        <img src="{{ asset('profiles/' . $postProfile->image) }}" alt="Profile Picture"
                            class="profile-pic me-3">
                    @else
                        <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    @endif
                    <div class="profile-name">{{ $post->user->userName }}</div>
                    <div class="post-subtitle mb-2 small">
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
                </div>
                <div class="post-content mb-0">
                    <p class="content">{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ asset('posts/' . $post->image) }}" class="post-image" alt="Post image">
                    @endif
                </div>

                <!-- like and comment Section -->
                <div class="footer-info">
                    {{-- love reaction --}}
                    <form action="{{ route('posts.toggleLove', $post->id) }}" method="POST" class="me-0"
                        style="display:inline;">
                        @csrf
                        <button class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                fill="{{ $hasLoved ? '#dc3545' : '#fff' }}"
                                class="bi {{ $hasLoved ? 'bi-heart-fill' : 'bi-heart' }}" viewBox="0 0 16 16">
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
                    <button class="card-link">
                        <svg class="cmt-svg" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                            width="20px" fill="#fff">
                            <path
                                d="M880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                        </svg>
                    </button>
                    @if ($post->comments->count())
                        <p class="cmt-count">{{ $post->comments->count() }}</p>
                    @else
                        <p hidden></p>
                    @endif
                </div>
                <hr class="hr">

                
                {{-- Comment Section --}}
                <div class="comment-sec">
                    <!-- Existing comments -->
                    @forelse ($post->comments as $comment)
                        <div id="commentsSection-{{ $comment->id }}" class="comment-header d-flex mb-1" data-comment-id="{{ $comment->id }}">
                            @php
                                $commentProfile = $comment->user->profile;
                            @endphp
                            @if ($commentProfile && $commentProfile->image && file_exists(public_path('profiles/' . $commentProfile->image)))
                                <img src="{{ asset('profiles/' . $commentProfile->image) }}" alt="Profile Picture" class="profile-pic mr-2">
                            @else
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic mr-2">
                            @endif

                            <div class="comment-content">
                                <a href="{{ route('profile.show', $comment->user->id) }}" class="profile-name mb-1">{{ $comment->user->userName }}</a>
                                <p class="content mb-1">{{ $comment->content }}</p>
                            </div>

                            <div class="comment-sub small">
                                <div class="post-sub mb-2 small">
                                    <div class="post-subtitle small">
                                        {{ timeDiffInHours($comment->created_at) }}
                                    </div>
                                    @if (auth()->id() === $post->user->id || auth()->user()->can('delete', $comment))
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE') <!-- Specify the DELETE method -->
                                            <button type="submit" class="delete-btn">
                                                {{ __('DELETE')}}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="comment-yet" id="commentYet">
                            <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="#fff">
                                <path
                                    d="M880-80 720-240H320q-33 0-56.5-23.5T240-320v-40h440q33 0 56.5-23.5T760-440v-280h40q33 0 56.5 23.5T880-640v560ZM160-473l47-47h393v-280H160v327ZM80-280v-520q0-33 23.5-56.5T160-880h440q33 0 56.5 23.5T680-800v280q0 33-23.5 56.5T600-440H240L80-280Zm80-240v-280 280Z" />
                            </svg>
                            {{ __('No comments yet.') }}
                        </p>
                    @endforelse

                    <!-- Add comment -->
                    <div class="post-footer">
                        <form action="{{ route('comments.store', $post->id) }}" id="commentForm" method="POST">
                            @csrf
                            <div class="comment-box">
                                <input type="text" name="content" placeholder="Write a comment..." class="comment-input" />
                                <button class="send-btn" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 664 663">
                                        <path fill="none"
                                            d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888">
                                        </path>
                                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="33.67"
                                            stroke="#6c6c6c"
                                            d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        @if (session('error'))
                            <div class="alert alert-danger mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#fff" style="margin-right: 10px;">
                                    <path
                                        d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                // Handle comment submission
                $('#commentForm').on('submit', function(e) {
                    e.preventDefault();
                    // AJAX call for adding comment
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                // Construct new comment HTML
                                let newComment = `
                                    <div id="commentsSection-${response.commentId}" class="comment-header d-flex mb-1">
                                        <img src="${response.commentUserProfileImage}" alt="Profile Picture" class="profile-pic mr-2">
                                        <div class="comment-content">
                                            <a href="/profile/${response.commentUserId}" class="profile-name mb-1">${response.commentUserName}</a>
                                            <p class="content mb-1">${response.commentContent}</p>
                                        </div>
                                        <div class="comment-sub small">
                                            <div class="post-sub mb-2 small">
                                                <div class="post-subtitle small">
                                                    ${response.commentTimeAgo}
                                                </div>
                                                <button type="button" class="delete-btn btn btn-danger" data-comment-id="${response.commentId}">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>`;

                                $('.comment-sec').prepend(newComment);
                                $('.comment-yet').hide();
                                $('#commentForm').find('.comment-input').val('');
                            } else {
                                alert('Error adding comment.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                });
            });

        </script>
    @endsection