@extends('layouts.sidebar')
@section('title', 'Full Post')

@section('style')
    <link href="{{ asset('css/post_detail.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="scrollable-container p-4">

        <!-- back button -->
        <a href="{{ route('posts.index') }}"
            style="background:black; color:white; text-decoration:none; border:solid white;border-radius:10px; padding:10px 10px 10px 10px; margin-bottom:10px; position:fixed;">Back</a>

        <!-- Display post detail -->
        <div class="detail-content">
            <div class="post-container">
                <div class="post-header">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-name">{{ $post->user->userName }}</div>
                    <div class="post-subtitle mb-2 small">
                        {{ timeDiffInHours($post->created_at) }}
                    </div>
                </div>
                <div class="post-content">
                    <p class="content">{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ asset('posts/' . $post->image) }}" class="post-image" alt="Post image">
                    @endif
                </div>

                <!-- like and comment Section -->
                <div class="footer-info">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                            fill="#fff">
                            <path
                                d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z" />
                        </svg>
                    </button>
                    <button class="card-link">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                            fill="#fff">
                            <path
                                d="M880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                        </svg>
                    </button>
                </div>
                <hr style="color:white;">

                <!-- Existing comments -->
                <div class="comment-sec">
                    @forelse ($post->comments as $comment)
                        <div class="comment-header">
                            <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                            <div class="comment-content">
                                <div class="profile-name mb-1">{{ $comment->user->userName }}</div>
                                <p class="content mb-1">{{ $comment->content }}</p>
                                <div class="comment-sub">
                                    <div class="post-subtitle mb-2 small">
                                        <div class="post-subtitle mb-2 small">
                                            {{ timeDiffInHours($comment->created_at) }}
                                        </div>
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn">{{ __('Delete') }}</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="comment-yet">{{ __('No comments yet.') }}</p>
                    @endforelse

                    <!-- Add comment -->
                    <div class="post-footer">
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="comment-box">
                                <input type="text" name="content" placeholder="Add a comment..." class="comment-input" />
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