@extends('layouts.sidebar')
@section('title', 'Edit Post')

@section('style')
    <link href="{{ asset('css/post_create.css') }}" rel="stylesheet">

    <style>
        .form-actions {
            position: relative;
        }
    
        #add-image-icon {
            cursor: pointer;
            /* display: none;  */
        }
    
        .file-input {
            display: none; /* Hide the actual file input */
        }
    
        .image-container {
            position: relative;
            display: inline-block;
        }
    
        .preview-img {
            display: block;
            transition: opacity 0.3s ease;
        }
    
        .image-container:hover .preview-img {
            opacity: 0.3;
        }
    
        .delete-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            color: red;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: none;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 18px;
            line-height: 30px;
            text-align: center;
        }
    
        .image-container:hover .delete-btn {
            display: flex;
        }
    </style>
@endsection

@section('content')
    <div class="create-content p-4">
        <h5 class="new-post">{{ __('Edit Post') }}</h5>
        <div class="post-form-container">
            <div class="profile-section">
                <img src="{{ asset('images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                <div class="profile-name">{{ auth()->user()->userName }}</div>
            </div>
            <form action="{{ route('posts.update', $post->id) }}" method="POST" class="post-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <textarea name="content" class="form-control">{{ $post->content }}</textarea>
                <div class="form-actions d-flex justify-content-between align-items-center mt-2 position-relative">
                    <div id="add-image-icon" class="attachment-btn btn" style="display: none;">
                        <svg id="upload_svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #fff;">
                            <path d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z"></path>
                            <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                        </svg>
                        <input type="file" id="file-input" name="image" class="file-input">
                    </div>
                    <div class="image-container">
                        <img class="preview-img" id="image-preview" src="{{ asset('posts/'. $post->image) }}" alt="Preview Image">
                        <button type="button" id="remove-image" class="btn btn-danger delete-btn">×</button>
                    </div>
                </div>
                
                <div class="form-actions d-flex justify-content-between align-items-center mt-2">
                    <div class="privacy-options">
                        <select name="privacy" class="form-select">
                            @foreach(\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ $status->value == $post->status ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>                        
                    </div>
                    <button class="post-btn btn" type="submit">{{ __('Update') }}</button>
                </div>
            </form>
            @if (session('error'))
                <div class="alert alert-danger mt-2">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

@endsection

@section('script')
<script>
    document.getElementById("file-input").addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview").setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(file);
            document.getElementById('upload_svg').style.display = 'none';
        } else {
            document.getElementById("preview").setAttribute("src", "#");
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const addImageIcon = document.getElementById('add-image-icon');
    const imagePreview = document.getElementById('image-preview');
    const removeImageButton = document.getElementById('remove-image');
    const fileInput = document.getElementById('file-input');

    function updateImageState() {
        if (imagePreview.src != '') {
            addImageIcon.style.display = 'none'; // Hide SVG if image is present
            imagePreview.style.display = 'block';
        } else {
            console.log('hello');
            addImageIcon.style.display = 'block'; // Show SVG if no image
            imagePreview.style.display = 'none';
        }
    }
    updateImageState();

    addImageIcon.addEventListener('click', function() {
        fileInput.click();
    });

    removeImageButton.addEventListener('click', function() {
        fileInput.value = null;
        imagePreview.src = '';
        
        imagePreview.style.display = 'none';
        addImageIcon.style.display = 'block';
    });

    fileInput.addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                addImageIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });
});

</script>
@endsection
