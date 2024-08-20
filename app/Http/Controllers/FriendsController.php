<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\Friend;

class FriendsController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 
        $friends = Friend::where('user_id', $user->id)->get(); 
        $friendRequests = FriendRequest::where('receiver_id', $user->id)->get();

        return view('friends.index', compact('user', 'friends', 'friendRequests'));
    }

    public function sendRequest($receiverId)
    {
        $existingRequest = FriendRequest::where('sender_id', auth()->id())
                                        ->where('receiver_id', $receiverId)
                                        ->orWhere(function($query) use ($receiverId) {
                                            $query->where('sender_id', $receiverId)
                                                  ->where('receiver_id', auth()->id());
                                        })->first();

        if ($existingRequest) {
            return redirect()->back()->with('status', 'Friend request already exists or received.');
        }

        FriendRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
        ]);

        return redirect()->back()->with('status', 'Friend request sent!');
    }

    public function acceptRequest($requestId)
    {
        $request = FriendRequest::find($requestId);
        
        if (!$request) {
            return redirect()->back()->with('status', 'Friend request not found.');
        }

        $request->delete();

        Friend::create([
            'user_id' => $request->sender_id,
            'friend_id' => $request->receiver_id,
        ]);

        Friend::create([
            'user_id' => $request->receiver_id,
            'friend_id' => $request->sender_id,
        ]);

        return redirect()->back()->with('status', 'Friend request accepted!');
    }

    public function declineRequest($requestId)
    {
        $request = FriendRequest::find($requestId);
        
        if (!$request) {
            return redirect()->back()->with('status', 'Friend request not found.');
        }

        $request->delete();

        return redirect()->back()->with('status', 'Friend request declined!');
    }

    public function unfriend($friendId)
    {
        Friend::where(function ($query) use ($friendId) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('user_id', $friendId)
                  ->where('friend_id', auth()->id());
        })->delete();

        return redirect()->back()->with('status', 'Unfriended successfully!');
    }
}
