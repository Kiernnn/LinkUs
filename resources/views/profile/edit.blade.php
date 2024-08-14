@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="container" style="margin-top:100px; margin-left:500px; overflow:hidden; overflow-y:scroll; height:100vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center" style="font-size:30px;">{{ __('Edit Profile') }}</div>
                <div class="card-body" style="background:grey; display:flex; flex-direction:column; padding-bottom:20px;">
                    <form action="{{ route('profile.update', ['profile' => $profile->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="image">Profile Photo</label>
                            <input type="file" name="image" id="image" style="cursor:pointer;">
                            @if($profile->image)
                                <div>
                                    <img src="{{ asset('profiles/' . $profile->image) }}" alt="Profile Picture" style="width:150px; height:150px;">
                                </div>
                            @else
                                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea name="about" id="about" class="form-control">{{ old('about', $profile->about) }}</textarea>
                        </div>

                        <!-- back and Edit button -->
                        <div class="card-footer" style="margin:auto; margin-left:50px;">
                            <a href="{{ route('profile.index') }}" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                    <!-- Display Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
