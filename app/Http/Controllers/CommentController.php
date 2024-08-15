<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->save();

        return redirect()->route('posts.detail', $post->id)->with('success', 'Comment added successfully.');
    }

    public function show($id)
    {
        $data = Post::findOrFail($id);

        return view('posts.detail', ['post'=> $data]);
    }

    public function edit(Comment $comment)
    {
        return view ('posts.cmDetail', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content'=> 'required|string|max:255',
        ]);

        $comment->update($request->only('content'));

        return redirect()->route('posts.detail', $comment->id)->with('success','Comment Edit successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // Optional: Add Authorization

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

}
