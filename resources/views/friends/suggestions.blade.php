@extends('layouts.sidebar')
@section('title', 'Friend Suggestions')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.suggestions') }}" class="friends mb-2">{{ __('Suggestions') }}</a>
        <div class="friends-box">
            <div class="suggest-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests mb-2">{{ __('Suggested for you') }}</div>
                </div>
                @forelse ($suggestions as $user)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($user->profile && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $user->userName }}</div>
                                    <div id="successMessage{{ $user->id }}" class="add-fri"
                                        style="display: none; color: #808080; font-weight: bold;"></div>
                                </div>
                            </div>
                            <div class="buttons">
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button class="accept btn" id="addFriendBtn{{ $user->id }}"
                                        onclick="sendFriendRequest(event, {{ $user->id }})">
                                        {{ __('Add Friend') }}
                                    </button>
                                </form>
                                <form action="{{ route('friendRequests.cancel', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" id="removeBtn{{ $user->id }}" style="display: none;"
                                        onclick="declineFriReq(event, {{ $user->id }}); return false;">
                                        {{ __('Remove') }}
                                    </button>
                                </form>
                                <div id="statusMessage{{ $user->id }}" class="status-message"
                                    style="color: #808080; font-weight: bold; display: none;"></div>
                                <div id="successMessage{{ $user->id }}" class="status-message"
                                    style="color: #808080; font-weight: bold; display: none;"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: white">{{ __('No Suggestions Found!') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.history.replaceState({}, document.title, window.location.pathname);

        // Send friend request
        function sendFriendRequest(event, userId) {
            event.preventDefault();

            var addFriendBtn = document.getElementById('addFriendBtn' + userId);
            var removeBtn = document.getElementById('removeBtn' + userId);
            var successMessage = document.getElementById('successMessage' + userId);
            var statusMessage = document.getElementById('statusMessage' + userId);
            var requestContainer = addFriendBtn.closest('.request-container');

            // Hide the Add Friend button
            addFriendBtn.style.display = 'none';

            // Show the Remove button and success message
            removeBtn.style.display = 'inline-block';
            successMessage.style.display = 'block';

            // Hide any previous status message
            statusMessage.style.display = 'none';

            // Optionally, make an AJAX request to handle friend request
            $.ajax({
                url: "{{ route('friendRequests.send') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    receiverId: userId,
                },
                success: function(response) {
                    // Update the success message text
                    successMessage.textContent = response.message;

                    // Optionally, remove the container after a delay
                    setTimeout(() => {
                        requestContainer.remove();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }

        // Cancel friend Reqest
        function declineFriReq(event, userId) {
            event.preventDefault(); // Prevent default form submission

            var removeBtn = document.getElementById('removeBtn' + userId);
            var statusMessage = document.getElementById('statusMessage' + userId);
            var successMessage = document.getElementById('successMessage' + userId);

            $.ajax({
                url: "{{ route('friendRequests.cancel', '') }}/" + userId, // URL with userId
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}" // CSRF token for security
                },
                success: function(response) {
                    // Hide the Remove button and success message
                    removeBtn.style.display = 'none';
                    successMessage.style.display = 'none';

                    // Show the status message
                    statusMessage.textContent = "Friend Request Cancelled";
                    statusMessage.style.display = 'block';
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                    statusMessage.textContent = "Error: " + error;
                    statusMessage.style.display = 'block';
                }
            });
        }
    </script>
@endsection
