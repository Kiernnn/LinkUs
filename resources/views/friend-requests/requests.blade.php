@extends('layouts.sidebar')
@section('title', 'Friend Requests')

@section('style')
    <link href="{{ asset('css/friends_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friendRequests.requests') }}" class="friends mb-2">{{ __('Friend Requests') }}</a>
        <div class="friends-box">
            <div class="request-form-container mb-3">
                <div class="post-header mb-3">
                    @forelse ($friendRequests as $data)
                        @php $sender = $data->sender; @endphp <!-- Eager load sender -->
                        <div class="request-container mb-2">
                            <a href="{{ route('profile.show', $sender->id) }}" class="profile mb-0">
                                <img src="{{ asset($sender->profile && $sender->profile->image ? 'profiles/' . $sender->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="name-and-subtitle mb-0">
                                    <div class="profile-name">{{ $sender->userName }}</div>
                                    <div class="post-subtitle mb-2 small">{{ timeDiffInHours($data->created_at) }}
                                    </div>
                                </div>
                            </a>

                            <div class="buttons mb-2">
                                <button class="accept btn" id="acceptBtn{{ $data->id }}"
                                    onclick="handleFriendRequest('accept', {{ $data->id }})">{{ __('Accept') }}</button>
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
                        <p style="color: #808080;">{{ __('No Friend Requests Found!') }}</p>
                    @endforelse
                </div>
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
    </script>
@endsection
