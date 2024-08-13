@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="container" style="margin-top:100px; margin-left:500px; overflow:hidden; overflow-y:scroll; height:100vh;" >
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center" style="font-size:30px;">{{ __('Edit Profile') }}</div>
                <div class="card-body" style="background:grey; display:flex; justify-content:space-between; padding -bottom:20px;">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="image">Profile Photo</label>
                            <input type="file" name="image" id="image" class="form-control" value="{{ $profile->image }}">
                        </div>
                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea name="about" id="about" class="form-control" r>{{ ( $profile->about) }}</textarea>
                        </div>
                        <!-- back button -->
                        <a href="{{ route('profile.index') }}" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
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