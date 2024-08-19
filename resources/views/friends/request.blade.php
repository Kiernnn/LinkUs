@extends('layouts.sidebar')
@section('title', 'Friends')

@section('content')
<div class="container">
    <h1>Pending Friend Requests</h1>

    @if($friendRequests->isEmpty())
        <p>No friend requests.</p>
    @else
        <ul>
            @foreach($friendRequests as $request)
                <li>
                    {{ $request->sender->name }}
                    <!-- Accept Button -->
                    <a href="{{ route('friends.acceptRequest', $request->id) }}" class="btn btn-success btn-sm">Accept</a>
                    <!-- Decline Button -->
                    <a href="{{ route('friends.declineRequest', $request->id) }}" class="btn btn-danger btn-sm">Decline</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
