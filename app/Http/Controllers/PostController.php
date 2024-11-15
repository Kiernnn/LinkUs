<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use App\Models\Love;
use App\Models\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\helpers;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at','desc')
            ->where('user_id','!=',auth()->user()->id)
            ->where(function ($query) {
                $query->where('status', PostStatus::PUBLIC->value)
                    ->orWhere(function ($query) {
                        $query->where('status', PostStatus::FRIENDS->value)
                            ->whereHas('user.friends', function ($query) {
                                $query->where('friend_id', auth()->user()->id)
                                      ->orWhere('user_id', auth()->user()->id);
                        });
                })
                ->orWhere('user_id', auth()->user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            $post->hasLoved = $post->loves()->where('user_id', auth()->id())->exists();
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                                'privacy' => 'required|in:public,friends,me',
                                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2M
                                'content' => 'nullable',
                            ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->content == null && !$request->hasFile('image')) {
            return redirect()->back()->with('error', 'Post cannot be created without content or photo.');
        }

        try {
            $image = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $image = uploadFile($file, 'posts');
            }

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'status' => $request->privacy,
                'content' => $request->content ?? null,
                'image' => $image ?? null,
            ]);

            return redirect()->route('profile.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the post.');
        }
    }

    public function show(Post $post)
    {
        return view('posts.detail', compact('post'));
    }

    public function edit(Post $post)
    {
        if(auth()->user()-> id !== $post->user_id) {
            return view('posts.index', compact('post'));
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'privacy' => 'required|in:public,friends,me',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2M
            'content' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {
            $post->update([
                'status' => $request->privacy,
                'content' => $request->content,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if($post->image) {
                    deleteFile($post->image, 'posts');
                }
                $image = uploadFile($file, 'posts');
                $post->image = $image ?? NULL;
                $post->save();
            }

            return redirect()->route('profile.index')->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while creating the post.');
        }

    }

    // Comment
    public function detail(Post $post)
    {
        return view('posts.detail', compact('post'));
    }

    public function back(Post $post)
    {
        return view('posts.detail', compact('post'));
    }

    public function destroy(Post $post)
    {
        // dd($post);
        if ($post->user_id !== auth()->user()->id) {
            abort(404, 'You are not authorized to delete this post.');
        }

        $post->delete();

        return redirect()->route('profile.index')->with('success', 'Post deleted successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;

        if (!$keyword) {
            return redirect()->back()->with('error', 'Please enter a keyword to search.');
        }

        $posts = Post::where('content', 'like', '%' .$keyword. '%')
                    ->where(function ($query) {
                        $query->where('status', PostStatus::PUBLIC->value)
                            ->orWhere(function ($query) {
                                $query->where('status', PostStatus::FRIENDS->value)
                                        ->whereHas('user', function ($query) {
                                            $query->whereHas('friends', function ($query) {
                                                $query->where('friend_id', auth()->user()->id)
                                                    ->orWhere('user_id', auth()->user()->id);
                                            });
                                        });
                            })
                            ->orWhere('user_id', auth()->user()->id);
                    })
                    ->orderBy('created_at','desc')
                    ->limit(5)
                    ->get();

        $users = User::where('userName', 'like', '%' .$keyword. '%')
            ->orWhere('firstName', 'like', '%' . $keyword . '%')
            ->orWhere('lastName', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('posts.index', compact('posts', 'users', 'keyword'));
    }

    public function searchUsers($keyword)
    {
        $users = User::where('userName', 'like', '%' .$keyword. '%')
            ->orWhere('firstName', 'like', '%' . $keyword . '%')
            ->orWhere('lastName', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('posts.search-users', compact('users', 'keyword'));
    }

    public function searchPosts($keyword)
    {
        $posts = Post::where('content', 'like', '%' .$keyword. '%')
        ->where(function ($query) {
            $query->where('status', PostStatus::PUBLIC->value)
                ->orWhere(function ($query) {
                    $query->where('status', PostStatus::FRIENDS->value)
                            ->whereHas('user', function ($query) {
                                $query->whereHas('friends', function ($query) {
                                    $query->where('friend_id', auth()->user()->id)
                                        ->orWhere('user_id', auth()->user()->id);
                                });
                            });
                })
                ->orWhere('user_id', auth()->user()->id);
        })
        ->orderBy('created_at','desc')
        ->get();

        return view('posts.search-posts', compact('posts', 'keyword'));
    }

    public function toggleLove(Request $request, Post $post)
    {
        $user = auth()->user();
    
        // Check if the user has already loved the post
        $hasLoved = $post->loves()->where('user_id', $user->id)->exists();

        if ($hasLoved) {
            // If loved, remove the love
            $post->loves()->where('user_id', $user->id)->delete();
            $hasLoved = false;
        } else {
            // If not loved, add the love
            $post->loves()->create(['user_id' => $user->id]);
            $hasLoved = true;
        }
        return response()->json([
            'success' => true,
            'hasLoved' => $hasLoved,
            'loveCount' => $post->loves()->count(),
        ]);
    }

    public function getLovers(Post $post)
    {
        // Fetch the users who loved the post
        $lovers = $post->loves()->with('user')->get();

        return response()->json([
            'success' => true,
            'lovers' => $lovers,
        ]);
    }
}
