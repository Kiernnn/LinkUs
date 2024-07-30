<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:public,friends,me',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($request->content == null && !$request->photo){
            return redirect()->back()->with('error','Post Cannot be Created');
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('posts', $filename, 'public');
        }
        
        $post = Post::create([
                'user_id' => auth()->user()->id,
                'status' => $request->status,
                'caption' => $request->content ?? null,
                'image' => $filename ?? null,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully.');
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
