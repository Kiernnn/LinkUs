@extends('layouts.sidebar')
@section('title', 'Friend Profile')

@section('style')
    {{-- <link rel="stylesheet" href="css/friends.css"> --}}
    <style>
        .container {
            margin-left: 120px;
            padding-top: 20px;
            height: 100vh;
            display: flex;
            gap: 20px;
            overflow: hidden;
        }
        .left-column, .right-column {
            flex: 1;
            margin-top: 30px;
            overflow-y: auto;
            background-color: #2c3e50;
            padding: 20px;
            border-radius: 10px;
        }
        .friend-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .button {
            padding: 5px 15px;
            border-radius: 20px;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #16a085;
        }
        .button-unfriend {
            background-color: #e74c3c;
        }
        .button-cancel {
            background-color: #e74c3c;
        }
        .button-accept {
            background-color: #2ecc71;
        }
        .button-decline {
            background-color: #e74c3c;
        }
        .button-search, .button-add {
            background-color: #333;
        }
    </style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" style="margin-left: 120px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-left: 120px;">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="container">
        
        <!-- Left Column: Friends List and Friend Requests -->
        <div class="left-column">
            <h3>Friends</h3>
            @foreach ($friends as $friend)
                <div class="friends" style="display: flex; align-items: center; margin-bottom: 15px;">
                    @php
                        $friendProfile = $friend->user_id == Auth::id() ? $friend->friend->profile : $friend->user->profile;
                    @endphp
                    <img src="{{ $friendProfile && $friendProfile->image && file_exists(public_path('profiles/' . $friendProfile->image)) ? asset('profiles/' . $friendProfile->image) : asset('images/user_default.png') }}" alt="Profile Picture" class="friend-pic">
                    <div class="nameTime">
                        <p>{{ $friend->user_id == Auth::id() ? $friend->friend->userName : $friend->user->userName }}</p>
                        <div class="post-subtitle mb-2 small">
                            {{ timeDiffInHours($friend->created_at) }}
                        </div>
                    </div>
                    <form action="{{ route('friends.unfriend', $friend->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-unfriend">Unfriend</button>
                    </form>
                </div>
            @endforeach


            <h3>Friend Requests</h3>
            @foreach ($friendRequests as $request)
                <div style="margin-bottom: 15px;">
                    <p>{{ $request->sender->userName }}</p>
                    <form action="{{ route('friendRequests.accept', $request->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="button button-accept">Accept</button>
                    </form>
                    <form action="{{ route('friendRequests.decline', $request->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-decline">Decline</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Right Column: Search and Add Friends -->
        <div class="right-column">
            <div style="background-color: #444; padding: 20px; border-radius: 20px; margin-bottom: 20px;">
                <h3>Search Friends</h3>
                <form action="{{ route('friends.search') }}" method="GET" style="text-align: center;">
                    <input type="text" name="query" placeholder="Search users..." required style="padding: 10px; width: 80%; border-radius: 20px; border: 1px solid #ccc; margin-bottom: 10px;">
                    <button type="submit" class="button button-search">Search</button>
                </form>
            </div>

            <div class="add-friends" style="background-color: #555; padding: 20px; border-radius: 20px;">
                <h3>Add Friends</h3>
                @if(isset($searchResults) && count($searchResults) > 0)
                    <h4>Search Results:</h4>
                    @foreach ($searchResults as $user)
                        <div style="margin-bottom: 15px;">
                            <p>{{ $user->userName }}</p>
                            @if(in_array($user->id, $sentRequests))
                                <button disabled class="button" style="background-color: #aaa;">Pending</button>
                                <form action="{{ route('friendRequests.cancel', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-cancel">Cancel</button>
                                </form>
                            @else
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="button button-add">Add Friend</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @elseif(isset($searchResults))
                    <p>No users found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
