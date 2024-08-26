@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('content')
    <div class="requests-content p-4">
        <h2>{{ __('All Friend Requests') }}</h2>
        @foreach($friendRequests as $request)
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
        @endforeach
    </div>
@endsection