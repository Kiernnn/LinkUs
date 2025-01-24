@extends('layouts.sidebar')
@section('title', 'Friends list')

@section('style')
    <link href="{{ asset('css/friend_lists.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="friends-content p-4">
        <a href="{{ route('friends.index') }}" class="friends mb-2">{{ __('Friends') }}</a>
        <div class="friends-box">
            <div class="fri-form-container mb-3">
                <div class="friends-info mb-2">
                    @php
                        $friendUser = $friends->isNotEmpty()
                            ? ($friends[0]->user_id == $viewingUser->id
                                ? $friends[0]->friend
                                : $friends[0]->user)
                            : null;
                    @endphp
                    <div class="friend-requests mb-2">
                        {{ $viewingUser->id == auth()->id() ? 'Your friends' : $viewingUser->userName . " 's friends" }}
                    </div>
                </div>
                <div class="post-header mb-3">
                    @forelse ($friends as $friend)
                        @php
                            $friendUser = $friend->user_id == $viewingUser->id ? $friend->friend : $friend->user;
                        @endphp
                        <div class="friends-container mb-2" id="friendContainer{{ $friendUser->id }}">
                            <a href="{{ route('profile.show', $friendUser->id) }}" class="profile mb-0">
                                <img src="{{ asset($friendUser->profile && $friendUser->profile->image ? 'profiles/' . $friendUser->profile->image : 'images/user_default.png') }}"
                                    alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $friendUser->userName }}</div>
                                </div>
                            </a>

                            <div class="buttons">
                                <form class="unfriend-form" data-friend-id="{{ $friendUser->id }}">
                                    @csrf
                                    <button class="unfriend btn" id="unfriendBtn{{ $friendUser->id }}" type="button"
                                        onclick="unfri({{ $friendUser->id }})">
                                        {{ __('Unfriend') }}
                                    </button>
                                </form>
                                <div class="notiMsg{{ $friendUser->id }}"
                                    style="color: #808080; font-weight: bold; transition: opacity 0.3s ease, height 0.3s ease;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="color: #808080;">{{ __('You have no friends.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function unfri(friendId) {
            var unfriendBtn = document.getElementById('unfriendBtn' + friendId);
            var friendContainer = unfriendBtn.closest('.friends-container'); 
            var message = friendContainer.querySelector('.notiMsg' + friendId);

            $.ajax({
                url: "{{ route('friends.unfriend', '') }}/" + friendId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    unfriendBtn.style.display = 'none';
                    message.textContent = response.message; 
                    message.style.display = 'block';

                    setTimeout(() => {
                        friendContainer.style.transition = 'opacity 0.3s ease, height 0.3s ease';
                        friendContainer.style.opacity = '0';
                        friendContainer.style.height = '0';
                        setTimeout(() => {
                            friendContainer.remove();
                        }, 300); // Delay to allow transition to complete
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + xhr.responseText || error);
                }
            });
        }

    </script>
@endsection

