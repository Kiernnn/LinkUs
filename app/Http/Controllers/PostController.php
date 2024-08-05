<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\helpers;
use Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all();
        
        // $page = $request->input('page', 1);
        // $posts = Post::paginate(10, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json(['posts' => $posts]);
        }

        return view('posts.index', compact('posts'));
    }
    
    public function create()
    {
        
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
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
                $image = $file->store('posts'); // Store the image
            }

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'status' => $request->privacy,
                'content' => $request->content ?? null,
                'image' => $image ?? null,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'An error occurred while creating the post.');
        }
    }

    // Comment 
    public function detail($id)
    {
        $data = Post::find($id);

        return view('posts.detail', ['post'=> $data]);
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
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->update([
            'status' => $request->status,
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

    public function delete(Post $post)
    {
        // dd($post);
        if ($post->user_id !== auth()->user()->id) {
            abort(403, 'You are not authorized to delete this post.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
