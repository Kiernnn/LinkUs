@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" style="margin-top:100px; margin-left:500px;" >
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center" style="font-size:30px;">{{ __('Profile') }}</div>
                <div class="card-body" style="background:grey; display:flex; justify-content:space-between; padding -bottom:20px;">
                    <div class="text-center" style="display:block;">
                        <h3 class="text-center">{{ $user->userName }}</h3>
                        <h5 class="text-center" style="border: solid white; border-radius:10px; width:auto; padding:5px 5px 5px 5px; ">{{$user->email}}</h5>
                        <p class="text-center">{{ $profile->about }}</p>
                    </div>
                    <div class="text-center">
                    <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic" style="border-radius:50%; width:100px; height:100px;">
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('profile.edit', ['profile' => $profile->id]) }}" class="btn btn-primary">Edit</a>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
