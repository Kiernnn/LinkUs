@extends('layouts.sidebar')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('css/profile_edit.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="profile-content p-4">
        <h5 class="profile">{{ __('Edit Profile') }}</h5>
        <div class="post-form-container">
            <form action="{{ route('profile.update', ['profile' => auth()->user()->profile ? auth()->user()->profile->id : '']) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-wrapper">
                    <div class="edit-wrapper">
                        <label for="name" class="label-name">Name</label>
                        <div class="subname">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px"
                                fill="#fff">
                                <path
                                    d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                            </svg>
                            <p class="firstName">{{ auth()->user()->firstName }}</p>
                            <p class="lastName">{{ auth()->user()->lastName }} </p>
                            <p class="profile-name">({{ auth()->user()->userName }})</p>
                        </div>
                        <hr class="underline">
                        <div class="form-group mb-2">
                            <label for="about" class="label-name">{{ __('Bio') }}</label>
                            <textarea name="about" id="about" class="form-control">{{ old('about', auth()->user()->profile ? auth()->user()->profile->about : '') }}</textarea>
                        </div>
                    </div>
                    <div class="profile-wrapper">
                        @if (auth()->user()->profile && auth()->user()->profile->image)
                            <img src="{{ asset('profiles/' . auth()->user()->profile->image) }}" class="profile-pic"
                                alt="Profile Picture" id="profile-pic">
                        @else
                            <img src="{{ asset('images/user_default.png') }}" class="profile-pic" alt="Profile Picture"
                                id="profile-pic">
                        @endif
                        <svg class="upload_svg" id="upload_svg" xmlns="http://www.w3.org/2000/svg" height="24px"
                            viewBox="0 -960 960 960" width="24px" fill="#fff">
                            <path
                                d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                        </svg>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control"
                            style="display: none;">
                    </div>
                </div>

                <div class="buttons" style="display:flex;">
                    <!-- Update button -->
                    <button class="post-btn btn" type="submit">{{ __('Done') }}</button>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#fff" style="margin-right: 10px;">
                        <path
                            d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif


        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('upload_svg').addEventListener('click', function() {
            document.getElementById('image').click();
        });

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-pic').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
