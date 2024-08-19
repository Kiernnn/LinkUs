@extends('layouts.sidebar')
@section('title', 'Friends')

@section('style')
    <link href="{{ asset('css/friends.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="friends-content p-4" style="color:white;">
        <h1 style="color:white;">Friends Page</h1>
    </div>

    <!-- Friend Request Button -->
    <div class="send-friend-request">
        <h2 style="color:white;">Send Friend Request</h2>
        <form action="{{ route('friends.sendRequest', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-custom" style="background:white; color:black;">Send Friend Request</button>
        </form>
    </div>

    <!-- Friend List -->
    <div class="friendLi">
        <h2 style="color:white;">Friend List</h2>
        @if($friends->isEmpty())
            <p style="color:white;">You have no friends yet.</p>
        @else
            <ul>
                @foreach($friends as $friend)
                    <li style="color:white;">
                        {{ $friend->name }}
                        <!-- Unfriend Button -->
                        <form action="{{ route('friends.unfriend', $friend->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="background:white; color:black;">Unfriend</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Friend Requests -->
    <h2 style="color:white;">Friend Requests</h2>
    @if($friendRequests->isEmpty())
        <p style="color:white;">No friend requests.</p>
    @else
        <ul>
            @foreach($friendRequests as $request)
                <li style="color:white;">
                    {{ $request->sender->name }}
                    <!-- Accept and Decline Buttons -->
                    <form action="{{ route('friends.acceptRequest', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" style="background:white; color:black;">Accept</button>
                    </form>
                    <form action="{{ route('friends.declineRequest', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" style="background:white; color:black;">Decline</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
