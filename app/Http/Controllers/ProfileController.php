<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\FriendRequest;
use App\helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Exception;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $viewingUser = auth()->user();
        $friendRequests = FriendRequest::where('receiver_id', $viewingUser->id)
        ->where('status', 'pending')
        ->get(); // Fetch friend requests for the authenticated user
        $posts = $viewingUser->posts()->orderBy('created_at', 'desc')->get();
        // return view('profile.index', compact( 'viewingUser', 'posts'));
        return view('profile.index', compact('viewingUser', 'friendRequests', 'posts'));
    }

    public function show($id) {
        $viewingUser = User::with('profile')->findOrFail($id);
        $friendRequests = FriendRequest::where('receiver_id', $viewingUser->id)
        ->where('status', 'pending')
        ->get();
        $posts = $viewingUser->posts()->orderBy('created_at', 'desc')->get();

        return view('profile.index', compact('viewingUser', 'friendRequests', 'posts'));
    } 

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'about' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = auth()->user(); 
        $user->userName = $request->userName;
        $user->save(); 

        // $profile = auth()->user()->profile;
        // if (!$profile) {
        //     $profile = new Profile();
        // }

        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        try {
            $profile->update([
                'about' => $request->about,
                'userName' => $request->userName,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($profile->image) {
                    deleteFile($profile->image, 'profiles');
                }
                $image = uploadFile($file, 'profiles');

                $profile->image = $image ?? null;
            }
            $profile->save();

            return redirect()->route('profile.index')->with('success', 'Profile Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Profile Update Failed !');
        }
    }
}
