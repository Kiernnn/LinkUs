@extends('layouts.sidebar')
@section('title', 'Full Post')

@section('style')
    <link href="{{ asset('css/post_detail.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="scrollable-container p-4">
        
        <!-- back button -->
        <a href="{{ route('posts.index') }}" id="back" class="btn btn-primary" >Back</a>

        <!-- Display post detail -->
        <div class="detail-content">
            
            <div class="post-container">

                <!-- Edit Form -->
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                
                <!-- Delete button -->
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline; margin-right: 0;">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                </form>

                <div class="post-header">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-name" style="color:white;">{{ $post->user->userName }}</div>
                </div>
                <div class="post-subtitle mb-2 small" style="color:white;">
                    {{ $post->created_at->diffForHumans() }}
                </div>
                <div class="post-content">
                    <p class="content" style="color:white;">{{ $post->content }}</p><br><br>
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="max-width:100%; color:white;">
                    @endif
                </div>

                <!-- Comment Section -->
                <div class="footer-info">
                    <button>Like</button>
                    <button class="card-link" style="text-decoration:none;">Comment</button>
                </div>
                <hr style="color:white;">
                
                <!-- Existing comments -->
                <div class="comment-sec" style="background:rgb(108, 108, 108); border-radius:15px;">
                @forelse ($post->comments as $comment)
                        <div class="comment" style="display:block; margin-left:10px;">
                            <div class="post-header">
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                                <div class="profile-name" style="color:white;">{{ $comment->user->userName }}</div>
                            </div>
                            <div class="post-subtitle mb-2 small" style="color:white; margin-left:50px">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                            <p style="color:white;"><strong style="color:white; margin-left:50px;">{{ $post->user->name }}</strong>{{ $comment->content }}</p>

                            <div class="modify" style="display:flex; justify-content:space-evenly;">
                                <!-- Edit comment -->    
                                <a href="{{ route('comments.edit', $comment->id) }}" class="card-link" style="text-decoration:none;color:white;">
                                    Edit
                                </a>
                                
                                
                                <!-- delete comment -->
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p style="color:white;">No comments yet.</p>
                    @endforelse
                </div>

                <!-- New comment -->
                <div class="post-footer">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-name" style="color:white;">{{ auth()->user()->userName }}</div>

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
                    <div class="alert alert-danger" style="width:200px; height:40px; padding:5px 5px 5px 5px; text-decoration:none; margin-left:100px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <span>{{ "Write something!" }}</span>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
