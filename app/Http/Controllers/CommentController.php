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

            return response()->json(['success' => true, 'comment' => $comment]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Write something to comment!']);
        }
    }

    public function edit(Comment $comment)
    {
        try {
            $postId = $comment->post_id;
            return view('posts.cmDetail', compact('comment', 'postId'));
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

            if (auth()->id() === $comment->user_id) {
                $comment->update($request->only('content'));
                return redirect()->route('posts.detail', $comment->post_id)->with('success', 'Comment edited successfully.');
            }

            return redirect()->route('posts.detail', $comment->post_id)->with('success', 'Comment edited successfully.');
        } catch (Exception $e) {
            return redirect()->route('posts.detail', $comment->post_id)->with('error', 'Failed to edit comment: ' . $e->getMessage());
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);

            $comment->delete();

            return redirect()->back()->with('success', 'Comment deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete comment: ' . $e->getMessage());
        }
    }
}
