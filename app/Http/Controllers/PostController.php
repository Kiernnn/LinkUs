<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\helpers;
use Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', '!=', auth()->user()->id)
                        ->get();

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
                                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2M
                            ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->all());
        }

        if ($request->content == null && !$request->file) {
            return redirect()->back()->with('error', 'Post cannot be created without content or photo.');
        }

        try {
            $image = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $image = uploadFile($file, 'posts');
            }

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'status' => $request->privacy,
                'caption' => $request->content ?? null,
                'image' => $image ?? null,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while creating the post');
        }
    }


    public function show(Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:public,friends,me',
            'caption' => 'nullable|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->update([
            'status' => $request->status,
            'caption' => $request->caption,
            'content' => $request->content,
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('photos', $filename, 'public');
            $post->photo = $filePath;
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        dd($post);
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.create')->with('success', 'Post deleted successfully.');
    }
}
