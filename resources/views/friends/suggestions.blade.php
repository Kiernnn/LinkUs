@extends('layouts.sidebar')

@section('title', 'Friend Suggestions')

@section('content')
    <div class="suggestions-content p-4" style="margin-left: 120px;">
        <!-- back button -->
        <a href="{{ route('friends.index') }}"
            style="background:black; color:white; text-decoration:none; border:solid white;border-radius:10px; padding:10px 10px 10px 10px; margin-bottom:10px; position:fixed;">Back
        </a>

        <div class="suggestions-box" style="height:100vh; overflow: hidden; overflow-y:auto; margin-bottom:20px; text-align:center;">
            <h2 style="color:white;">{{ __('Friend Suggestions') }}</h2>
            @forelse ($suggestions as $user)
                <div class="suggestion mb-3 mt-5">
                    <div class="profile">
                        <img src="{{ asset($user->profile && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                        <div class="profile-name" style="color: white;">{{ $user->userName }}</div>
                    </div>
                    <div class="buttons">
                        <form action="{{ route('friendRequests.send', $user->id )}}" method="POST" style="display: inline;">
                            @csrf
                            <button class="btn btn-primary" type="submit">{{ __('Add Friend') }}</button>
                        </form>
                        <form action="{{ route('friends.removeSuggestion', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit">{{ __('Remove') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No suggestions available!</p>
            @endforelse
        </div>
    </div>
@endsection
