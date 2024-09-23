<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use App\Models\Love;
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
                            ->whereHas('user', function ($query) {
                                $query->whereHas('friends', function ($query) {
                                    $query->where('friend_id', auth()->user()->id)
                                          ->orWhere('user_id', auth()->user()->id);
                                });
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

        // $posts = Post::where('content', 'like', '%' .$keyword. '%')
        //                 ->orderBy('created_at','desc')
        //                 ->get();

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
        
        $users = User::where('userName', 'like', '%' .$keyword. '%')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('posts.index', compact('posts', 'users', 'keyword'));
    }

    public function toggleLove(Request $request, Post $post)
    {
        \Log::info('Toggle love for post ID: ' . $post->id);

        $love = $post->loves()->where('user_id', auth()->id())->first();

        if ($love) {
            $love->delete(); 
        } else {
            $post->loves()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
