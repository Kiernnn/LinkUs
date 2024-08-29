@extends('layouts.sidebar')
@section('title', 'Friends list')

@section('style')
    <link href="{{ asset('css/friend_lists.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" style="overflow:hidden; overflow-y:auto; height:100vh; scrollbar-width:none; ">
    <div class="row justify-content-center" style="margin-top:10px; margin-bottom: 20px;">
        <div class="col-md-8">
            <h2 class="text-center" style="margin-top: 20px; color:white;">{{ __('Friends List') }}</h2>
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Friends List -->
            <div class="friends-list" style="margin-top: 20px;">
                @forelse ($friends as $friend)
                    @php
                        // Determine the friend's user model
                        $friendUser = $friend->user_id == auth()->id() ? $friend->friend : $friend->user;
                    @endphp

                    <div class="friend-item" style="margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 10px;">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ asset($friendUser->profile && $friendUser->profile->image ? 'profiles/' . $friendUser->profile->image : 'images/user_default.png') }}" alt="Profile Picture" class="friend-pic" style="border-radius:50%; width:60px; height:60px;">
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $friendUser->userName }}</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <form action="{{ route('friends.unfriend', ['friendId' => $friendUser->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Unfriend</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <hr style="color:white;">
                    <p style="color:white; text-align:center; font-size:30px;">You have no friends yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
