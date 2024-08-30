@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friends') }}</a>
        <div class="friends-box">

            <!-- Fri Requests Section Start -->
            <div class="request-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friends mb-2">{{ __('Friend Requests') }}</div>
                    <a href="{{ route('friends.requests') }}" class="see-all">{{ __('See all') }}</a>
                    <a href="{{ route('friends.list')}}" class="friends-list" style="text-decoration:none;">{{ __('friends list')}}</a>
                </div>
                <div class="post-header mb-3">
                    @forelse ($friendRequests as $data)
                        @php $sender = \App\Models\User::find($data->sender_id); @endphp
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($sender->profile && $sender->profile->image ? 'profiles/' . $sender->profile->image : 'images/user_default.png') }}"
                                     alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="name-and-subtitle">
                                        <div class="profile-name">{{ $sender->userName }}</div>
                                        <div class="post-subtitle mb-2 small">{{ timeDiffInHours($data->created_at) }}</div>
                                    </div>
                                    <div class="accept-fri">{{ __('You are now friends') }}</div>
                                    <div class="accept-fri">{{ __('Request declined') }}</div>
                                </div>
                            </div>

                            <div class="buttons mb-2">
                                <button class="accept btn" id="acceptBtn{{ $data->id }}" onclick="handleFriendRequest('accept', {{ $data->id }})">
                                    {{ __('Accept') }}
                                </button>
                                <form action="{{ route('friendRequests.decline', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" id="declineBtn{{ $data->id }}" onclick="handleFriendRequest('decline', {{ $data->id }}); return false;">
                                        {{ __('Decline') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="color:white;">{{ __('No Friend Requests Found!') }}</p>
                    @endforelse
                </div>
            </div>
            <!-- Fri Requests Section End -->

            <!-- Suggestion Section Start -->
            <div class="suggest-form-container mb-3">
                <div class="friends-info mb-2">
                    <div class="friend-requests mb-2">{{ __('Suggested for you') }}</div>
                    <a href="{{ route('friends.suggestions', ['all' => true]) }}" class="see-all">{{ __('See all') }}</a>
                </div>
                @forelse ($suggestions as $user)
                    <div class="post-header mb-3">
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset(isset($user->profile) && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}"
                                     alt="Profile Picture" class="profile-pic">
                                     <div class="profile-info mb-0">
                                            <div class="profile-name">{{ $user->userName }}</div>
                                            <div id="successMessage{{ $user->id }}" class="add-fri" style="display: none; color: #808080; font-weight: bold;">{{ __('Friend request sent') }}</div>
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

            <!-- Suggestion Section End -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        function handleFriendRequest(action, reqId) {
            const acceptBtn = document.getElementById('acceptBtn' + reqId);
            const declineBtn = document.getElementById('declineBtn' + reqId);
            const requestContainer = acceptBtn.closest('.request-container');
            const profile = requestContainer.querySelector('.profile');
            const message = requestContainer.querySelector('.accept-fri');

            if (action === 'accept') {
                acceptBtn.style.display = 'none';
                declineBtn.style.display = 'none';
                message.textContent = "{{ __('You are now friends') }}";
            } else {
                acceptBtn.style.display = 'none';
                declineBtn.style.display = 'none';
                message.textContent = "{{ __('Request declined') }}";
            }

            message.style.display = 'block';
            message.style.visibility = 'visible';
            message.style.opacity = '1';

            setTimeout(() => {
                const transitionDuration = '0.3s';
                profile.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                profile.style.opacity = '0';
                profile.style.height = '0';
                profile.style.overflow = 'hidden';

                message.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                message.style.opacity = '0';
                message.style.height = '0';
                message.style.overflow = 'hidden';

                setTimeout(() => {
                    requestContainer.remove();
                }, 300);
            }, 2000);

            const url = action === 'accept' ? "{{ route('friendRequests.accept') }}" : "{{ route('friendRequests.decline', '') }}/" + reqId;
            const method = action === 'accept' ? 'POST' : 'DELETE';

            $.ajax({
                url: url,
                type: method,
                data: {
                    _token: "{{ csrf_token() }}",
                    reqId: reqId,
                },
                success: function(response) {
                    // Optionally handle success response
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }

        function sendFriendRequest(event, userId) {
            event.preventDefault(); // Prevent the default form submission

            const addFriendBtn = document.getElementById('addFriendBtn' + userId);
            addFriendBtn.style.display = 'none'; // Hide the button

            const successMessage = document.getElementById('successMessage' + userId);
            successMessage.style.display = 'block'; // Show the success message

            const requestContainer = addFriendBtn.closest('.request-container');

            $.ajax({
                url: "{{ route('friendRequests.send', '') }}/" + userId, // Construct the URL
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Optionally handle success response
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });

            // Apply effects similar to accept button
            setTimeout(() => {
                const transitionDuration = '0.3s';
                const profile = requestContainer.querySelector('.profile');
                profile.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                profile.style.opacity = '0';
                profile.style.height = '0';
                profile.style.overflow = 'hidden';

                successMessage.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                successMessage.style.opacity = '0';
                successMessage.style.height = '0';
                successMessage.style.overflow = 'hidden';
                // successMessage.style.color = '#808080 !important'; // Change color
                // successMessage.style.fontWeight = 'bold'; // Change font weight


                setTimeout(() => {
                    requestContainer.remove();
                }, 300);
            }, 2000);
        }
        
    </script>
@endsection