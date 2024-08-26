@extends('layouts.sidebar')
@section('title', 'Friends')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <div class="friends-box">
            <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friends') }}</a>
            <div class="request-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests">{{ __('Friend requests') }}</div>
                    <a href="#" class="see-all">{{ __('See all') }}</a>
                </div>
                <div class="post-header mb-3">
                    <div class="profile">
                        <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                        <div class="profile-name">{{ __('Kiernnn') }}</div>
                        <div class="post-subtitle mb-2 small">{{ __('1d') }}</div>
                    </div>
                    <div class="buttons mb-2">
                        <button class="accept btn" type="submit">{{ __('Accept') }}</button>
                        <button class="decline btn" type="submit">{{ __('Decline') }}</button>
                    </div>
                </div>
            </div>

            <div class="suggest-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests">{{ __('Suggested for you') }}</div>
                    <a href="#" class="see-all">{{ __('See all') }}</a>
                </div>
                <div class="post-header mb-3">
                    <div class="profile">
                        <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                        <div class="profile-name">{{ __('Kiernnn') }}</div>
                    </div>
                    <div class="buttons">
                        <button class="accept btn" type="submit">{{ __('Add Friend') }}</button>
                        <button class="decline btn" type="submit">{{ __('Remove') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
