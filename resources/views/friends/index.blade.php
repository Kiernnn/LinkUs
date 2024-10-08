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
                @forelse ($friends as $friend)
                    @php
                        $friendUser = $friend->user_id == $viewingUser->id ? $friend->friend : $friend->user;
                    @endphp
                    <div class="post-header mb-3">
                        <div class="friends-container mb-2" id="friendContainer{{ $friendUser->id }}">
                            <a href="{{ route('profile.show', $friendUser->id) }}" class="profile mb-0">
                                <img src="{{ asset($friendUser->profile && $friendUser->profile->image ? 'profiles/' . $friendUser->profile->image : 'images/user_default.png') }}"
                                     alt="Profile Picture" class="profile-pic">
                                <div class="profile-info mb-0">
                                    <div class="profile-name">{{ $friendUser->userName }}</div>
                                </div>
                            </a>
                            <div class="buttons">
                                @if ($viewingUser->id === auth()->id())
                                    <form action="{{ route('friends.unfriend', ['friendId' => $friendUser->id]) }}"
                                          method="POST" class="unfriend-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="unfriend btn" id="unfriendBtn{{ $friendUser->id }}"
                                            onclick="handleUnfriend(event, {{ $friendUser->id }});">{{ __('Unfriend') }}</button>
    
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #808080;">{{ __('You have no friends.') }}</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function handleUnfriend(event, friendId) {
        event.preventDefault(); 

        var requestContainer = document.getElementById('friendContainer' + friendId);
        const url = "{{ route('friends.unfriend', '') }}/" + friendId;

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.message) {
                    console.log(response.message); 
                }
                requestContainer.remove();
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }
</script>
@endsection