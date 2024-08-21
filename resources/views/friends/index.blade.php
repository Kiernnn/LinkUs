@extends('layouts.sidebar')
@section('title', 'Friends')

@section('style')
    <link href="{{ asset('css/friends.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>Your Friends</h1>
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
    @if($friends->isEmpty())
        <p>No friends yet.</p>
    @else
        <ul>
            @foreach($friends as $friend)
                <li>
                    {{ $friend->friend->name }}
                    <form action="{{ route('friends.unfriend', $friend->friend_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Unfriend</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

