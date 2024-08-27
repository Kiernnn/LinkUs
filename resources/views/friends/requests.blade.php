@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.requests') }}" class="friends mb-2">{{ __('Friend Requests') }}</a>
        <div class="friends-box">
            <div class="request-form-container mb-3">
                @forelse ($friendRequests as $request)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <div class="profile">
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                                <div class="profile-name">{{ $request->sender->userName }}</div>
                                <div class="post-subtitle mb-2 small">
                                    {{ timeDiffInHours($request->created_at) }}
                                </div>
                            </div>
                            <div class="buttons mb-2">
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
                    </div>
                @empty
                    <p style="color:white;">{{ __('No Friend Requests Found!') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
