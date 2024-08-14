@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" style="margin-top:100px; margin-left:500px; overflow:hidden; overflow-y:scroll; height:100vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
            <div class="card-header text-center" >
                <h3 class="header text-center" style="font-size:30px;">{{ __('Profile') }}</h3>
                <a href="{{ route('profile.edit', ['profile' => $profile->id]) }}" class="btn btn-primary">Edit</a>
            </div>
                <div class="card-body" style="background:grey; display:flex; justify-content:space-between; padding -bottom:20px;">
                    <div class="text-center" style="display:block;">
                        <h3 class="text-center">{{ $user->userName }}</h3>
                        <p class="text-center" style="border:5px red;">{{ $profile->about }}</p>
                    </div>
                    <div class="text-center">
                        @if ($profile->image)
                            <img src="{{ asset('profiles/' . $profile->image) }}" class="profile-image" alt="Profile image" style="width:150px; height:150px; border-radius:15px;">
                        @endif
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
