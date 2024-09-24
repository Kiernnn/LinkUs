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

                    <p class="privacy">
                        <strong>
                            @if($post->status === 'public')
                                <i class="fas fa-globe" title="Public"></i>
                            @elseif($post->status === 'friends')
                                <i class="fas fa-user-friends" title="Friends"></i>
                            @elseif($post->status === 'me')
                                <i class="fas fa-lock" title="Me"></i>
                            @else
                                <i class="fas fa-question" title="Unknown"></i>
                            @endif
                        </strong>
                    </p>
                </div>
                <div class="post-content mb-0">
                    <p class="content">{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ asset('posts/' . $post->image) }}" class="post-image" alt="Post image">
                    @endif
                </div>

                <!-- like and comment Section -->
                <div class="footer-info">
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
                <hr style="color:white; margin-top: 0px;">

                <!-- Existing comments -->
                <div class="comment-sec">
                    @forelse ($post->comments as $comment)
                        <div class="comment-header d-flex mb-1">
                            @php
                                $commentProfile = $comment->user->profile;
                            @endphp
                            @if ($commentProfile && $commentProfile->image && file_exists(public_path('profiles/' . $commentProfile->image)))
                                <img src="{{ asset('profiles/' . $commentProfile->image) }}" alt="Profile Picture"
                                    class="profile-pic mr-2">
                            @else
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture"
                                    class="profile-pic mr-2">
                            @endif
                            <div class="comment-content">
                                <a href="{{ route('profile.show', $comment->user->id) }}"
                                    class="profile-name mb-1">{{ $comment->user->userName }}</a>
                                <p class="content mb-1">{{ $comment->content }}</p>
                            </div>
                            <div class="comment-sub small">
                                <div class="post-sub mb-2 small">
                                    <div class="post-subtitle text-secondary mb-2 small">
                                        {{ timeDiffInHours($comment->created_at) }}
                                    </div>
                                    @if (auth()->id() === $post->user->id || auth()->user()->can('delete', $comment))
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn">{{ __('Delete') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class=" comment-yet">
                            <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px"
                                fill="#fff">
                                <path
                                    d="M880-80 720-240H320q-33 0-56.5-23.5T240-320v-40h440q33 0 56.5-23.5T760-440v-280h40q33 0 56.5 23.5T880-640v560ZM160-473l47-47h393v-280H160v327ZM80-280v-520q0-33 23.5-56.5T160-880h440q33 0 56.5 23.5T680-800v280q0 33-23.5 56.5T600-440H240L80-280Zm80-240v-280 280Z" />
                            </svg>
                            {{ __('No comments yet.') }}
                        </p>
                    @endforelse

                    <!-- Add comment -->
                    <div class="post-footer">
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="comment-box">
                                <input type="text" name="content" placeholder="Write a comment..."
                                    class="comment-input" />
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

    @section('scripts')
        <script>
            $(document).on('click', '.love-button', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Handle successful response, maybe update the love icon dynamically
                    },
                    error: function(response) {
                        // Handle error
                    }
                });
            });
        </script>
    @endsection
