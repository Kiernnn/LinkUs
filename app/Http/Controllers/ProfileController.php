<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendsController;
use App\Models\User;
use App\Models\Post;
use App\Models\FriendRequest;
use App\Models\Friend;
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
        $profile = $viewingUser->profile;

        $friends = Friend::with(['user', 'friend'])
         ->where(function ($query) use ($viewingUser) {
             $query->where('user_id', $viewingUser->id)
                   ->orWhere('friend_id', $viewingUser->id);
         })
         ->get()
         ->unique(function ($friend) use ($viewingUser) {
             // Ensure the friendship is only counted once regardless of direction
             return $friend->user_id == $viewingUser->id ? $friend->friend_id : $friend->user_id;
         });
        
        $friendRequests = FriendRequest::where('receiver_id', $viewingUser->id)
        ->where('status', 'pending')
        ->get(); 
        $posts = $viewingUser->posts()->orderBy('created_at', 'desc')->get();

        return view('profile.index', compact('viewingUser', 'friendRequests', 'friends', 'posts', 'profile'));
    }

    public function show($id) {
        $viewingUser = User::with('profile')->findOrFail($id);
        $authUserId = auth()->user()->id;

        $friends = Friend::with(['user', 'friend'])
         ->where(function ($query) use ($viewingUser) {
             $query->where('user_id', $viewingUser->id)
                   ->orWhere('friend_id', $viewingUser->id);
         })
         ->get()
         ->unique(function ($friend) use ($viewingUser) {
             // Ensure the friendship is only counted once regardless of direction
             return $friend->user_id == $viewingUser->id ? $friend->friend_id : $friend->user_id;
         });

        // Get pending friend requests where current user is the receiver
        $friendRequests = FriendRequest::where('receiver_id', $authUserId)
                                        ->where('status', 'pending')
                                        ->get();

        // Check if a friend request has been sent by the viewing user to the current user
        $friendRequestFromViewingUser = FriendRequest::where('sender_id', $viewingUser->id)
                                                     ->where('receiver_id', $authUserId)
                                                     ->where('status', 'pending')
                                                     ->first();

        // Check if the current user has sent a friend request to the viewing user
        $friendRequestFromAuthUser = FriendRequest::where('sender_id', $authUserId)
                                                  ->where('receiver_id', $viewingUser->id)
                                                  ->where('status', 'pending')
                                                  ->first();

        // Check if the two users are already friends
        $isFriend = Friend::where(function ($query) use ($authUserId, $id) {
            $query->where('user_id', $authUserId)
                  ->where('friend_id', $id);
        })->orWhere(function ($query) use ($authUserId, $id) {
            $query->where('user_id', $id)
                  ->where('friend_id', $authUserId);
        })->exists();

        $posts = $viewingUser->posts()
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

        return view('profile.index', compact('viewingUser', 'friendRequests', 'posts', 'friends', 'isFriend','friendRequestFromViewingUser', 'friendRequestFromAuthUser'));
    } 

    public function edit()
    {
        $profile = auth()->user()->profile;

        return view('profile.edit', compact('profile'));
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

        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = new Profile();
        }

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
