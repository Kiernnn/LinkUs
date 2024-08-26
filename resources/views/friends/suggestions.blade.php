@extends('layouts.sidebar')
@section('title', 'Friend Suggestions')

@section('content')
    <div class="suggestions-content p-4 " style="">
        <h2>{{ __('Friend Suggestions') }}</h2>
        @foreach($suggestions as $suggestion)
            <div class="friend-suggestion mb-3">
                <div class="profile">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-name">{{ $suggestion->userName }}</div>
                </div>
                <div class="buttons">
                    <form method="POST" action="{{ route('friendRequests.send', $suggestion->id) }}">
                        @csrf
                        <button class="accept btn" type="submit">{{ __('Add Friend') }}</button>
                    </form>
                    <form method="POST" action="#">
                        @csrf
                        @method('DELETE')
                        <button class="decline btn" type="submit">{{ __('Remove') }}</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
