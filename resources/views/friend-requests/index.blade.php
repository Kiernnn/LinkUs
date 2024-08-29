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
                    <div href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friend Requests') }}</div>
                    <a href="{{ route('friends.requests') }}" class="see-all">{{ __('See all') }}</a>
                </div>
                <div class="post-header mb-3">
                    @forelse ($friendRequests as $data)
                        @php
                            $sender = \App\Models\User::find($data->sender_id);
                        @endphp
                        <div class="request-container mb-2">
                            <div class="profile mb-0">
                                <img src="{{ asset($sender->profile && $sender->profile->image ? 'profiles/' . $sender->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="name-and-subtitle">
                                        <div class="profile-name">{{ $sender->userName }}</div>
                                        <div class="post-subtitle mb-2 small">
                                            {{ timeDiffInHours($data->created_at) }}
                                        </div>
                                    </div>
                                    <div class="accept-fri">{{ __('You are now friends') }}</div>
                                    <div class="accept-fri">{{ __('Request declined') }}</div>
                                </div>
                            </div>

                            <div class="buttons mb-2">
                                <button class="accept btn" type="submit" id="acceptBtn{{ $data->id }}"
                                    onclick="acceptFriReq({{ $data->id }})">
                                    {{ __('Accept') }}
                                </button>
                                <form action="{{ route('friendRequests.decline', $data->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="decline btn" type="submit" id="declineBtn{{ $data->id }}"
                                        onclick="declineFriReq({{ $data->id }}); return false;">
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
                            <div class="profile">
                                <img src="{{ asset(isset($user->profile) && $user->profile->image ? 'profiles/' . $user->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-name">{{ $user->userName }}</div>
                            </div>
                            <div class="buttons">
                                <form action="{{ route('friendRequests.send', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button class="accept btn" type="submit">{{ __('Add Friend') }}</button>
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
        // Accept friend requests section start
        function acceptFriReq(reqId) {
            const acceptBtn = document.getElementById('acceptBtn' + reqId);
            const declineBtn = acceptBtn.nextElementSibling;
            acceptBtn.style.display = 'none';
            declineBtn.style.display = 'none';

            const requestContainer = acceptBtn.closest('.request-container');
            const profile = requestContainer.querySelector('.profile');
            const acceptFriMessage = requestContainer.querySelector('.accept-fri');

            acceptFriMessage.textContent = "{{ __('You are now friends') }}";
            acceptFriMessage.style.display = 'block';
            acceptFriMessage.style.visibility = 'visible';
            acceptFriMessage.style.opacity = '1';

            setTimeout(function() {
                const transitionDuration = '0.3s';

                profile.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                profile.style.opacity = '0';
                profile.style.height = '0';
                profile.style.overflow = 'hidden';

                acceptFriMessage.style.transition =
                    `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                acceptFriMessage.style.opacity = '0';
                acceptFriMessage.style.height = '0';
                acceptFriMessage.style.overflow = 'hidden';

                setTimeout(function() {
                    requestContainer.remove();
                }, 300);
            }, 2000);

            $.ajax({
                url: "{{ route('friendRequests.accept') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    reqId: reqId,
                },
                success: function(response) {

                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
        // Accept friend requests section end

        // Decline friend requests section start
        function declineFriReq(reqId) {
            const acceptBtn = document.getElementById('acceptBtn' + reqId);
            if (acceptBtn) {
                acceptBtn.style.display = 'none';
            }

            const declineBtn = document.getElementById('declineBtn' + reqId);
            if (declineBtn) {
                declineBtn.style.display = 'none';
            }

            const requestContainer = declineBtn.closest('.request-container');
            const profile = requestContainer.querySelector('.profile');
            const removeFriMessage = requestContainer.querySelector('.accept-fri');

            removeFriMessage.textContent = "{{ __('Request declined') }}";
            removeFriMessage.style.display = 'block';
            removeFriMessage.style.visibility = 'visible';
            removeFriMessage.style.opacity = '1';

            setTimeout(function() {
                const transitionDuration = '0.3s';

                profile.style.transition = `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                profile.style.opacity = '0';
                profile.style.height = '0';
                profile.style.overflow = 'hidden';

                removeFriMessage.style.transition =
                    `opacity ${transitionDuration} ease, height ${transitionDuration} ease`;
                removeFriMessage.style.opacity = '0';
                removeFriMessage.style.height = '0';
                removeFriMessage.style.overflow = 'hidden';

                setTimeout(function() {
                    requestContainer.remove();

                    const remainingRequests = document.querySelectorAll('.request-container');
                    if (remainingRequests.length === 0) {
                        const noRequestsMessage = document.querySelector('.no-requests-message');
                        noRequestsMessage.style.display = 'block';
                    }
                }, 300);
            }, 2000);
        }
        // Decline friend requests section end
    </script>
@endsection
