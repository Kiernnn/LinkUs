@extends('layouts.sidebar')
@section('title', 'Friends')

@section('content')
<div class="container">
    <h1>Send Friend Request</h1>

    <form action="{{ route('friends.sendRequest', $user->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Send Request</button>
        <a href="{{ route('friends.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
