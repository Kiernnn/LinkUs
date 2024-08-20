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
                        {{ $post->created_at->diffForHumans() }}
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
                <div class="comment-sec" style="border-radius:15px;">
                    @forelse ($post->comments as $comment)
                        <div class="comment-header" style="display:block;">
                            <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                            <div class="profile-name">{{ $comment->user->userName }}</div>
                        </div>
                        <div class="comment-content">
                            <p class="content ml-10px">{{ $comment->content }}</p>
                        </div>
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endcan
                    @empty
                        <p class="content">{{ __('No comments yet.') }}</p>
                    @endforelse

                    <!-- New comment -->
                    <div class="post-footer">
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
                        <div class="alert alert-danger"
                            style="width:200px; height:40px; padding:5px 5px 5px 5px; text-decoration:none; margin-left:100px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <span>{{ 'Write something!' }}</span>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endsection
