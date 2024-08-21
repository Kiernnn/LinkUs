@extends('layouts.sidebar')
@section('title', 'Friends')

@section('content')
<div class="container">
    <h1>Friend Requests</h1>
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
    @if($friendRequests->isEmpty())
        <p>No friend requests.</p>
    @else
        <ul>
            @foreach($friendRequests as $request)
                <li>
                    {{ $request->sender->name }}
                    <form action="{{ route('friendRequests.acceptRequest', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <form action="{{ route('friendRequests.declineRequest', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
