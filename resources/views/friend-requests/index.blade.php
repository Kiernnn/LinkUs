@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="friends-content p-4">
        <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friends') }}</a>
        <div class="friends-box">

            <!-- Friend Requests Section -->
            <div class="request-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friends mb-2">{{ __('Friend Requests') }}</div>
                    <a href="{{ route('friends.requests') }}" class="see-all">{{ __('See all') }}</a>
                    <a href="{{ route('friends.list') }}" class="friends-list" style="text-decoration:none;">{{ __('friends list') }}</a>
                </div>
                <div class="post-header mb-3">
                    @forelse ($friendRequests as $data)
                        @php $sender = $data->sender; @endphp <!-- Eager load sender -->
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($sender->profile->image ?? 'images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="name-and-subtitle">
                                        <div class="profile-name">{{ $sender->userName }}</div>
                                        <div class="post-subtitle mb-2 small">{{ timeDiffInHours($data->created_at) }}</div>
                                    </div>
                                    <div class="notiMsg{{ $data->id}}"></div>
                                    
                                </div>
                            </div>

                            <div class="buttons mb-2">
                                <button class="accept btn" id="acceptBtn{{ $data->id }}" onclick="handleFriendRequest('accept', {{ $data->id }})">{{ __('Accept') }}</button>
                                <form action="{{ route('friendRequests.decline', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" id="declineBtn{{ $data->id }}" onclick="handleFriendRequest('decline', {{ $data->id }}); return false;">{{ __('Decline') }}</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="color:white;">{{ __('No Friend Requests Found!') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Suggestions Section -->
            <div class="suggest-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests mb-2">{{ __('Suggested for you') }}</div>
                    <a href="{{ route('friends.suggestions', ['all' => true]) }}" class="see-all">{{ __('See all') }}</a>
                </div>
                @forelse ($suggestions as $user)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($user->profile->image ?? 'images/user_default.png') }}" alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $user->userName }}</div>
                                    <div id="successMessage{{ $user->id }}" class="add-fri" style="display: none; color: #808080; font-weight: bold;"></div>
                                </div>
                            </div>
                            <div class="buttons">
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button class="accept btn" id="addFriendBtn{{ $user->id }}" onclick="sendFriendRequest(event, {{ $user->id }})">{{ __('Add Friend') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: white">No Suggestions Found!</p>
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

            const url = action === 'accept' ? "{{ route('friendRequests.accept') }}" : "{{ route('friendRequests.decline', '') }}";
            const method = action === 'accept' ? 'POST' : 'DELETE';

            $.ajax({
                url: url,
                type: method,
                data: 
                {
                   _token: "{{ csrf_token() }}",
                   reqId : reqId,
                },
                success: function(response) {
                    console.log(response.message);
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

        // Send friend Request
        function sendFriendRequest(event, userId) {
            event.preventDefault(); 

            var addFriendBtn = document.getElementById('addFriendBtn' + userId);           
            var successMessage = document.getElementById('successMessage' + userId);
            
            $.ajax({
                url: "{{ route('friendRequests.send') }}",
                type: 'POST',
                data: 
                    { 
                        _token: "{{ csrf_token() }}",
                        receiverId : userId,
                    },
                success: function(response) {
                    addFriendBtn.style.display = 'none';
                    successMessage.style.display = 'block';
                    successMessage.textContent = response.message;
                },
                error: function(error) {
                    console.log(error);
                }
            });

            setTimeout(() => {
                const profile = addFriendBtn.closest('.request-container').querySelector('.profile');
                profile.style.transition = 'opacity 0.3s ease, height 0.3s ease';
                profile.style.opacity = '0';
                profile.style.height = '0';
                requestContainer.remove();
            }, 2000);
        }
    </script>
@endsection