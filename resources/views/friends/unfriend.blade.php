@extends('layouts.sidebar')
@section('title', 'Friends')

@section('content')
<div class="container">
    <h1>Unfriend {{ $friend->name }}?</h1>

    <p>Are you sure you want to unfriend {{ $friend->name }}?</p>

    <form action="{{ route('friends.unfriend', $friend->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Yes, Unfriend</button>
        <a href="{{ route('friends.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
