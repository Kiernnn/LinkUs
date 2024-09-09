@extends('layouts.sidebar')
@section('title', 'Create Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post_edit.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="create-content p-4">
        <a href="{{ route('posts.create') }}" class="new-post mb-2">{{ __('Create New Post') }}</a>
        <div class="post-form-container card p-4 shadow">
            <div class="profile-section d-flex mb-3">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture"
                    class="profile-pic rounded-circle me-2">
                <div class="profile-name">{{ auth()->user()->userName }}</div>
            </div>
            <form action="{{ route('posts.store') }}" method="POST" class="post-form" enctype="multipart/form-data">
                @csrf
                <textarea name="content" placeholder="What's on your mind?" class="form-control mt-2"></textarea>
                <div class="form-actions d-flex justify-content-between align-items-center mt-2 position-relative">
                    <div id="add-image-icon" class="attachment-btn btn">
                        <svg id="upload_svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" style="fill: #fff;">
                            <path d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z">
                            </path>
                            <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                        </svg>
                        <input type="file" id="file-input" name="image" class="file-input" style="display: none;">
                    </div>
                    <div class="image-container">
                        <img class="preview-img" id="image-preview" src="#" alt="Preview Image">
                        <button type="button" id="remove-image" class="delete-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 14"
                                class="svgIcon bin-top">
                                <g clip-path="url(#clip0_35_24)">
                                    <path fill="black"
                                        d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z">
                                    </path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_35_24">
                                        <rect fill="white" height="14" width="69"></rect>
                                    </clipPath>
                                </defs>
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 57"
                                class="svgIcon bin-bottom">
                                <g clip-path="url(#clip0_35_22)">
                                    <path fill="black"
                                        d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z">
                                    </path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_35_22">
                                        <rect fill="white" height="57" width="69"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-actions d-flex justify-content-between align-items-center mt-2">
                    <div class="privacy-options">
                        <select name="privacy" class="form-select">
                            @foreach (\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ $status === \App\Enums\PostStatus::PUBLIC ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="buttons" style="display:flex;">
                        <!-- Create button -->
                        <button class="post-btn btn" type="submit">{{ __('Create') }}</button>
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
            const addImageIcon = document.getElementById('add-image-icon');
            const imagePreview = document.getElementById('image-preview');
            const removeImageButton = document.getElementById('remove-image');
            const fileInput = document.getElementById('file-input');
            const uploadSvg = document.getElementById('upload_svg');

            function updateImageState() {
                if (fileInput.files.length > 0) {
                    // If there's a file selected, show the preview and remove button
                    imagePreview.style.display = 'block';
                    removeImageButton.style.display = 'flex';
                    addImageIcon.style.display = 'none';
                } else {
                    // If no file is selected, show the add image icon and hide others
                    imagePreview.style.display = 'none';
                    removeImageButton.style.display = 'none';
                    addImageIcon.style.display = 'block';
                }
            }

            addImageIcon.addEventListener('click', function() {
                fileInput.click();
            });

            removeImageButton.addEventListener('click', function() {
                fileInput.value = ''; // Clear the file input
                imagePreview.src = ''; // Clear the image preview
                uploadSvg.style.display = 'block'; // Show the SVG icon again
                updateImageState(); // Update state to show add-image-icon
            });

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        uploadSvg.style.display = 'none'; // Hide SVG icon when image is present
                        updateImageState
                            (); // Update state to hide add-image-icon and show preview and remove button
                    };
                    reader.readAsDataURL(file);
                } else {
                    uploadSvg.style.display = 'block'; // Show SVG when no file is selected
                    updateImageState(); // Update state to show add-image-icon
                }
            });

            // Initial state check
            updateImageState();
        });
    </script>
@endsection
