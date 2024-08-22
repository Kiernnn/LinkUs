@extends('layouts.sidebar')
@section('title', 'Friend Profile')

@section('style')
    <link href="{{ asset('css/friends.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>{{ $friend->name }}</h1>
    <!-- Add any additional information you want to display about the friend -->
    <p>Email: {{ $friend->email }}</p>
    <p>About: {{ $friend->about }}</p>
</div>
@endsection
