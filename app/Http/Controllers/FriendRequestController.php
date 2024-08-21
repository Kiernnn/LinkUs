<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;

class FriendRequestController extends Controller
{

    public function index(){
        $userId = auth()->user()->id;
        $friendRequests = FriendRequest::where('receiver_id', $userId)->with('sender')->get();
        return view('friends.friend_requests', compact('friendRequests'));

        return view('friendRequests.index', compact('friendRequests'));
    }

    public function sendRequest($receiverId)
    {
        $senderId = auth()->user()->id;
        
        if (FriendRequest::where('sender_id', $senderId)->where('receiver_id', $receiverId)->exists()) {
            return redirect()->back()->with('message', 'Friend request already sent.');
        }

        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
        ]);

        return redirect()->back()->with('success', 'Friend request sent.');
    }

    public function acceptRequest($requestId)
    {
        $friendRequest = FriendRequest::findOrFail($requestId);

        Friend::create([
            'user_id' => $friendRequest->receiver_id,
            'friend_id' => $friendRequest->sender_id,
        ]);

        Friend::create([
            'user_id' => $friendRequest->sender_id,
            'friend_id' => $friendRequest->receiver_id,
        ]);

        $friendRequest->delete();

        return redirect()->back()->with('success', 'Friend request accepted.');
    }

    public function declineRequest($requestId)
    {
        $friendRequest = FriendRequest::findOrFail($requestId);
        $friendRequest->delete();

        // if ($request->receiver_id !== auth()->user()->id) {
        //     return redirect()->back()->with('error', 'Unauthorized action.');
        // }

        // $request->update(['status' => 'declined']);

        return redirect()->back()->with('success', 'Friend request declined.');
    }

    public function cancelRequest($requestId)
    {
        $friendRequest = FriendRequest::findOrFail($requestId);
        $friendRequest->delete();

        return redirect()->back()->with('message', 'Friend request canceled.');
    }
}
