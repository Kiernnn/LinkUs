@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="profile-content p-4">
        <h5 class="profile">{{ __('Profile') }}</h5>
        <div class="post-form-container">
            <div class="profile-section">
                <div class="profile-info">
                    <div class="profile-name">{{ auth()->user()->userName }}</div>
                    <div class="subname">
                        <p class="firstName">{{ auth()->user()->firstName }}</p>
                        <p class="lastName">{{ auth()->user()->lastName }}</p>
                    </div>
                    <div class="bio">
                        <p class="bio-text">{{ $profile->about }}</p>
                    </div>
                </div>
                @if ($profile->image)
                    <img src="{{ asset('profiles/' . $profile->image) }}" class="profile-pic" alt="Profile image">
                @endif
            </div>

            <div class="profile-footer">
                <a href="{{ route('profile.edit', ['profile' => $profile->id]) }}"
                    class="post-btn btn">{{ __('Edit Profile') }}</a>
            </div>
        </div>
    </div>

@endsection
