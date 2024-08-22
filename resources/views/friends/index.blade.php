@extends('layouts.sidebar')
@section('title', 'Friend Profile')

@section('content')
    <div class="container" style="margin-left: 120px; padding-top: 20px; height: 100vh; overflow:hidden; overflow-y: auto; display: flex; gap: 20px;">
        
        <!-- Left Column: Friends List and Friend Requests -->
        <div class="left-column" style="flex: 1;">

            <!-- Friends List Section -->
            <div class="friend-list" style="background-color: #555; padding: 20px; border-radius: 20px; margin-bottom: 20px;">
                <h3 style="color: #fff;">Your Friends</h3>
                @foreach ($friends as $friend)
                    <div style="margin-bottom: 15px;">
                        <p style="color: #fff;">{{ $friend->user_id == Auth::id() ? $friend->friend->userName : $friend->user->userName }}</p>
                        <form action="{{ route('friends.unfriend', $friend->friend_id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 5px 15px; border-radius: 20px; border: none; background-color: #e74c3c; color: #fff;">Unfriend</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Friend Requests Section -->
            <div class="friend-requests" style="background-color: #666; padding: 20px; border-radius: 20px;">
                <h3 style="color: #fff;">Friend Requests</h3>
                @foreach ($friendRequests as $request)
                    <div style="margin-bottom: 15px;">
                        <p style="color: #fff;">{{ $request->sender->userName }}</p>
                        <form action="{{ route('friendRequests.accept', $request->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="padding: 5px 15px; border-radius: 20px; border: none; background-color: #2ecc71; color: #fff;">Accept</button>
                        </form>
                        <form action="{{ route('friendRequests.decline', $request->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 5px 15px; border-radius: 20px; border: none; background-color: #e74c3c; color: #fff;">Decline</button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Right Column: Search and Add Friends -->
        <div class="right-column" style="flex: 1;">

            <!-- Search Form -->
            <div style="background-color: #444; padding: 20px; border-radius: 20px; margin-bottom: 20px;">
                <h3 style="color: #fff; text-align: center;">Search Friends</h3>
                <form action="{{ route('friends.search') }}" method="GET" style="text-align: center;">
                    <input type="text" name="query" placeholder="Search users..." required
                           style="padding: 10px; width: 80%; border-radius: 20px; border: 1px solid #ccc; margin-bottom: 10px;">
                    <button type="submit" style="padding: 10px 20px; border-radius: 20px; border: none; background-color: #333; color: #fff;">Search</button>
                </form>
            </div>

            <!-- Add Friends Section -->
            <div class="add-friends" style="background-color: #555; padding: 20px; border-radius: 20px;">
                <h3 style="color: #fff;">Add Friends</h3>
                @if(isset($searchResults) && count($searchResults) > 0)
                    <h4 style="color: #fff;">Search Results:</h4>
                    @foreach ($searchResults as $user)
                        <div style="margin-bottom: 15px;">
                            <p style="color: #fff;">{{ $user->userName }}</p>
                            @if(in_array($user->id, $sentRequests))
                                <button disabled style="padding: 5px 15px; border-radius: 20px; border: none; background-color: #aaa; color: #fff;">Pending</button>
                            @else
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="padding: 5px 15px; border-radius: 20px; border: none; background-color: #333; color: #fff;">Add Friend</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @elseif(isset($searchResults))
                    <p style="color: #fff;">No users found.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
