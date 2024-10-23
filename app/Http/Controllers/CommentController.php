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
            // $data = Post::findOrFail($id);
            $post = Post::with(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->findOrFail($id);
            
            return view('posts.detail', ['post' => $post]);
        } catch (Exception $e) {
            return redirect()->route('posts.index')->with('error', 'Write something to comment!');
        }
    }

    public function store(Request $request, $postId)
    {
        // Validate the request...
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->save();

        // Return a JSON response with necessary data
        return response()->json([
            'success' => true,
            'commentUserName' => $comment->user->userName,
            'commentUserId' => $comment->user->id,
            'commentUserProfileImage' => $comment->user->profile->image
                ? asset('profiles/' . $comment->user->profile->image)
                : asset('images/user_default.png'),
            'commentContent' => $comment->content,
            'commentTimeAgo' => timeDiffInHours($comment->created_at),
            'commentId' => $comment->id,
            'csrfToken' => csrf_token(),  // Return CSRF token for deletion
        ]);
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
