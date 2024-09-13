@extends('layouts.sidebar')
@section('title', 'Friends list')

@section('style')
    <link href="{{ asset('css/friend_lists.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friends') }}</a>
        <div class="friends-box">
            <div class="fri-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests mb-2">{{ 'Your friends' }}</div>
                </div>
                @forelse ($friends as $friend)
                    @php
                        $friendUser = $friend->user_id == $viewingUser->id ? $friend->friend : $friend->user;
                    @endphp
                    <div class="post-header mb-3">
                        <div class="friends-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($friendUser->profile && $friendUser->profile->image ? 'profiles/' . $friendUser->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $friendUser->userName }}</div>
                                </div>
                            </div>
                            <div class="buttons">
                                <form action="{{ route('friends.unfriend', ['friendId' => $friendUser->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="unfriend btn">{{ __('Unfriend') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: white">{{ __('You have no friends.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
