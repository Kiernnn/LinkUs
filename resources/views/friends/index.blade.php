@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <div class="friends-box">
            <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friend Requests') }}</a>
            <div class="friends-info mb-2">
                <a href="{{ route('friends.requests') }}" class="see-all">{{ __('See all') }}</a>
            </div>
            @forelse ($friendRequests as $data)
                @php
                    $sender = \App\Models\User::find($data->sender_id);   
                @endphp
                
                <div class="request-form-container mb-3">
                    
                    <div class="post-header mb-3">
                        <div class="profile">
                            <img src="{{ asset($sender->profile->image ? 'profiles/' . $sender->profile->image : 'images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                            <div class="profile-name">{{ $sender->userName }}</div>
                            <div class="post-subtitle mb-2 small">
                                {{ timeDiffInHours($sender->created_at) }}
                            </div>
                        </div>
                        <div class="buttons mb-2">
                            <form action="{{ route('friendRequests.accept', $data->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button class="accept btn" type="submit">{{ __('Accept') }}</button>
                            </form>
                            <form action="{{ route('friendRequests.decline', $data->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="decline btn" type="submit">{{ __('Decline') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color:white;">No Friend Requests Found!</p>
            @endforelse

            <div class="suggest-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests">{{ __('Suggested for you') }}</div>
                    <a href="{{ route('friends.suggestions') }}" class="see-all">{{ __('See all') }}</a>
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
