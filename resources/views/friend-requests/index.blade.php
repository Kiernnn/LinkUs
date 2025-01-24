@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="friends-content p-4">
        <div class="friends-box">
            <!-- Friend Requests Section -->
            <div class="request-form-container mb-3">
                <a href="{{ route('friends.index') }}" class="friends mb-3">{{ __('Friends') }}</a>
                <div class="title-links mb-4">
                    <a href="{{ route('friendRequests.requests') }}" class="links">{{ __('Friend requests') }}</a>
                    <a href="{{ route('friendRequests.suggestions', ['all' => true]) }}"
                        class="links">{{ __('Suggestions') }}</a>
                    <a href="{{ route('friends.list') }}" class="links">{{ __('Your friends') }}</a>
                </div>
                <hr class="hr">
                <div class="friends-info mb-2">
                    <div class="friends mb-2">{{ __('Friend requests') }}</div>
                    <a href="{{ route('friendRequests.requests') }}" class="see-all">{{ __('See all') }}</a>
                </div>
                <div class="post-header mb-3">
                    @forelse ($friendRequests as $data)
                        @php $sender = $data->sender; @endphp
                        <div class="request-container mb-2">
                            <a href="{{ route('profile.show', $sender->id) }}" class="profile mb-0">
                                <img src="{{ asset($sender->profile && $sender->profile->image ? 'profiles/' . $sender->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="name-and-subtitle mb-0">
                                    <div class="profile-name">
                                        {{ $sender->userName }}</div>
                                    <div class="post-subtitle mb-2 small">{{ timeDiffInHours($data->created_at) }}</div>
                                </div>
                            </a>

                            <div class="buttons mb-2">
                                <button class="accept btn" id="acceptBtn{{ $data->id }}"onclick="handleFriendRequest('accept', {{ $data->id }})">{{ __('Accept') }}</button>
                                <form action="{{ route('friendRequests.decline', $data->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" id="declineBtn{{ $data->id }}"
                                        onclick="handleFriendRequest('decline', {{ $data->id }}); return false;">{{ __('Decline') }}</button>
                                </form>
                                <div class="notiMsg{{ $data->id }}"
                                    style="color: #808080; font-weight: bold; transition: opacity 0.3s ease, height 0.3s ease;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="color: #808080;">{{ __('No Friend Requests.') }}</p>
                    @endforelse
                </div>
                <hr class="hr">

                <!-- Suggestions Section -->
                <div class="friends-info mb-2">
                    <div class="friend-requests mb-2">{{ __('Suggested for you') }}</div>
                    <a href="{{ route('friendRequests.suggestions') }}" class="see-all">{{ __('See all') }}</a>
                </div>
                @forelse ($suggestions as $user)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <a href="{{ route('profile.show', $user->id) }}" class="profile mb-0">
                                <img src="{{ asset($user->profile && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $user->userName }}</div>
                                    <div id="successMessage{{ $user->id }}" class="add-fri"
                                        style="display: none; color: #808080; font-weight: bold;"></div>
                                </div>
                            </a>
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
                                        {{ __('Cancel') }}
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
                    <p style="color: #808080">No Suggestions.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Friend Request (accept, decline)
        function handleFriendRequest(action, reqId) {
            var acceptBtn = document.getElementById('acceptBtn' + reqId);
            var declineBtn = document.getElementById('declineBtn' + reqId);
            var requestContainer = acceptBtn.closest('.request-container');
            var profile = requestContainer.querySelector('.profile');
            var message = requestContainer.querySelector('.notiMsg' + reqId);

            const url = action === 'accept' ? "{{ route('friendRequests.accept') }}" :
                "{{ route('friendRequests.decline', '') }}/" + reqId;
            const method = action === 'accept' ? 'POST' : 'DELETE';

            $.ajax({
                url: url,
                type: method,
                data: {
                    _token: "{{ csrf_token() }}",
                    reqId: reqId,
                },
                success: function(response) {
                    acceptBtn.style.display = 'none';
                    declineBtn.style.display = 'none';
                    message.textContent = response.message;
                    message.style.display = 'block';

                    setTimeout(() => {
                        profile.style.transition = 'opacity 0.3s ease, height 0.3s ease';
                        profile.style.opacity = '0';
                        profile.style.height = '0';
                        requestContainer.remove();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }

        // Suggestion(add, remove)
        function sendFriendRequest(event, userId) {
            event.preventDefault();

            var addFriendBtn = document.getElementById('addFriendBtn' + userId);
            var removeBtn = document.getElementById('removeBtn' + userId);
            var successMessage = document.getElementById('successMessage' + userId);
            var statusMessage = document.getElementById('statusMessage' + userId);
            var requestContainer = addFriendBtn.closest('.request-container');

            addFriendBtn.style.display = 'none';

            removeBtn.style.display = 'inline-block';
            successMessage.style.display = 'block';

            $.ajax({
                url: "{{ route('friendRequests.send') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    receiverId: userId,
                },
                success: function(response) {
                    successMessage.textContent = response.message;

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
            event.preventDefault();

            var removeBtn = document.getElementById('removeBtn' + userId);
            var statusMessage = document.getElementById('statusMessage' + userId);
            var successMessage = document.getElementById('successMessage' + userId);

            $.ajax({
                url: "{{ route('friendRequests.cancel', '') }}/" + userId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    removeBtn.style.display = 'none';
                    successMessage.style.display = 'none';

                    statusMessage.textContent = "Friend Request Cancelled";
                    statusMessage.style.display = 'block';
                },
                error: function(xhr, status, error) {
                    statusMessage.textContent = "Error: " + error;
                    statusMessage.style.display = 'block';
                }
            });
        }
    </script>
@endsection
