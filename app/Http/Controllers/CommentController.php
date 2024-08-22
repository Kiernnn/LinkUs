<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string',
            ]);

            $comment = new Comment();
            $comment->content = $request->input('content');
            $comment->post_id = $post->id;
            $comment->user_id = auth()->id();
            $comment->save();

            return redirect()->route('posts.detail', $post->id)->with('success', 'Comment added successfully.');
        } catch (Exception $e) {
            return redirect()->route('posts.detail', $post->id)->with('error', 'Write something to comment!');
        }
    }

    public function show($id)
    {
        try {
            $data = Post::findOrFail($id);
            return view('posts.detail', ['post' => $data]);
        } catch (Exception $e) {
            return redirect()->route('posts.index')->with('error', 'Write something to comment!');
        }
    }

    public function edit(Comment $comment)
    {
        try {
            return view('posts.cmDetail', compact('comment'));
        } catch (Exception $e) {
            return redirect()->route('posts.detail', $comment->post_id)->with('error', 'Failed to retrieve comment: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Comment $comment)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:255',
            ]);

            $comment->update($request->only('content'));

            return redirect()->route('posts.detail', $comment->post_id)->with('success', 'Comment edited successfully.');
        } catch (Exception $e) {
            return redirect()->route('posts.detail', $comment->post_id)->with('error', 'Failed to edit comment: ' . $e->getMessage());
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment); // Optional: Add Authorization

            $comment->delete();

            return redirect()->back()->with('success', 'Comment deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete comment: ' . $e->getMessage());
        }
    }
}
