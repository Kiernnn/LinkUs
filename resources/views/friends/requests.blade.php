@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <style>
        .requests-content{
            height:100vh;
            overflow: hidden;
            overflow-y:auto;
            margin-bottom:20px;
            text-align:center;
        }
        .requests-content h2{
            color: white;   
        }
        .profile .profile-name{
            color: white;
        }
        .buttons{
            display: flex;
            text-align: center;
            justify-content: center
        }
        .buttons .decline{
            margin-left: 5px;
        }
        .buttons .accept, .decline{
            background: gray;
            padding: 5px 5px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
<di class="friendRequest" >
    <div class="requests-content p-4">
        <h2>{{ __('All Friend Requests') }}</h2>
        @forelse($friendRequests as $request)
            <div class="friend-request mb-3">
                <div class="profile">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-name">{{ $request->sender->userName }}</div>
                </div>
                <div class="buttons">
                    <form method="POST" action="{{ route('friendRequests.accept', $request->id) }}">
                        @csrf
                        <button class="accept btn" type="submit">{{ __('Accept') }}</button>
                    </form>
                    <form method="POST" action="{{ route('friendRequests.decline', $request->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="decline btn" type="submit">{{ __('Decline') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No Request.</p>
        @endforelse
    </div>
</di>
    
@endsection