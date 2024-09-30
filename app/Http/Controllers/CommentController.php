<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;

class CommentController extends Controller
{
    public function index($id) {
        try {
            $data = Post::findOrFail($id);
            return view('posts.detail', ['post' => $data]);
        } catch (Exception $e) {
            return redirect()->route('posts.index')->with('error', 'Write something to comment!');
        }
    }

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

    public function destroy(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);

            $comment->delete();

            return response()->json(['success' => 'Comment deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete comment: ' . $e->getMessage()], 400);
        }
    }
}
