@extends('layouts.sidebar')
@section('title', 'Friend Suggestions')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.suggestions') }}" class="friends mb-2">{{ __('Suggestions') }}</a>
        <div class="friends-box">
            <div class="suggest-form-container mb-3">
                @forelse ($suggestions as $user)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <div class="profile">
                                <img src="{{ asset($user->profile && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-name">{{ $user->userName }}</div>
                            </div>
                            <div class="buttons mb-2">
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="accept btn" type="submit">{{ __('Add Friend') }}</button>
                                </form>
                                <form action="{{ route('friends.removeSuggestion', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" type="submit">{{ __('Remove') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color:white;">{{ __('No suggestions available!') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
