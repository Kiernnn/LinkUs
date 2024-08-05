@extends("layouts.sidebar")
@section('title', 'Full Post')

@section('content')
<div class="container">
   <div class="card mb-2">
      <div class="card-body">
         <div class="card-subtitle mb-2 small">
            {{ $post->created_at->differForHumans() }},
            <h5 class="card-title">{{ $post->content }}</h5>

         </div>
      </div>
   </div>
      <ul class="list-group">
         <li class="list-group-item active">
            <b>Comments ({{ count($post->comments) }})</b>
         </li>
         @foreach ( $post->comments as $comment)
            <li class="list-group-item">
               {{ $comment->content }}
            </li>
         @endforeach
      </ul>

      <form action="{{ url('/comments/add') }}" method="post" >
         @csrf
         <input type="hidden" name="post_id" value="{{ $post->id }}">
         <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
         <input type="submit" value="And Comment" class="btn-btn-secondary">
      </form>
</div>
@endsection