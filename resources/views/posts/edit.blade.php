@extends('layouts.sidebar')
@section('title', 'Edit Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post_edit.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <h5 class="new-post mb-2">{{ __('Edit Post') }}</h5>
        <div class="post-form-container card p-4 shadow">
            <div class="profile-section d-flex mb-3">
                @if (auth()->user()->profile && auth()->user()->profile->image)
                    <img src="{{ asset('profiles/' . auth()->user()->profile->image) }}" alt="Profile Picture"
                        class="profile-pic rounded-circle me-2">
                @else
                    <img src="{{ asset('images/user_default.png') }} "alt="Profile Picture"
                        class="profile-pic rounded-circle me-2">
                @endif
                <div class="profile-name">{{ auth()->user()->userName }}</div>
            </div>
            <form action="{{ route('posts.update', $post->id) }}" method="POST" class="post-form"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <textarea name="content" class="form-control mt-2">{{ $post->content }}</textarea>
                <div class="form-actions d-flex justify-content-between align-items-center mt-2 position-relative">
                    <div id="add-image-icon" class="attachment-btn btn" style="display: none;">
                        <svg id="upload_svg" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                            width="24px" fill="#fff">
                            <path
                                d="M360-400h400L622-580l-92 120-62-80-108 140Zm-40 160q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z" />
                        </svg>
                        <input type="file" id="file-input" name="image" class="file-input">
                    </div>
                    <div class="image-container">
                        <img class="preview-img" id="image-preview" src="{{ asset('posts/' . $post->image) }}"
                            alt="">
                        <button type="button" id="remove-image" class="delete-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#e8eaed">
                                <path
                                    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-actions d-flex justify-content-between align-items-center mt-2">
                    <div class="privacy-options">
                        <select name="privacy" class="form-select">
                            @foreach (\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ $status->value == $post->status ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="buttons" style="display:flex;">
                        <!-- Cancel button -->
                        <a href="javascript:history.back()" class="post-btn btn" style="margin-right: 10px;">
                            {{ __('Cancel') }}
                        </a>

                        <!-- Update button -->
                        <button class="post-btn btn" type="submit">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            var addImageIcon = document.getElementById('add-image-icon');
            var imagePreview = document.getElementById('image-preview');
            var removeImageButton = document.getElementById('remove-image');
            var fileInput = document.getElementById('file-input');
            var uploadSvg = document.getElementById('upload_svg');

            function updateImageState() {
                if (imagePreview && imagePreview.src && imagePreview.src !== window.location.href && imagePreview
                    .src.trim() !== '') {
                    addImageIcon.style.display = 'block';
                    imagePreview.style.display = 'block';
                    removeImageButton.style.display = 'none';
                } else {
                    addImageIcon.style.display = 'block';
                    imagePreview.style.display = 'none';
                    removeImageButton.style.display = 'none';
                }
            }
            updateImageState();

            addImageIcon.addEventListener('click', function() {
                fileInput.click();
            });

            removeImageButton.addEventListener('click', function() {
                fileInput.value = '';
                imagePreview.src = '';
                uploadSvg.style.display = 'block';
                updateImageState();
            });

            fileInput.addEventListener('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        uploadSvg.style.display = 'block';
                        updateImageState();
                    };
                    reader.readAsDataURL(file);
                } else {
                    uploadSvg.style.display = 'block';
                    updateImageState();
                }
            });
            updateImageState();
        });
    </script>
@endsection
