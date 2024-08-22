<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FriendRequestController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get all friends of the authenticated user
        $friends = Friend::where('user_id', $userId)
                         ->orWhere('friend_id', $userId)
                         ->get();

        // Get all friend requests sent to the authenticated user
        $friendRequests = FriendRequest::where('receiver_id', $userId)->get();

        // Get all IDs of users to whom the authenticated user has sent friend requests
        $sentRequests = FriendRequest::where('sender_id', $userId)->pluck('receiver_id')->toArray();

        // Pass all variables to the view
        return view('friends.index', compact('friends', 'friendRequests', 'sentRequests'));
    }


    public function sendRequest($receiverId)
    {
        try {
            $senderId = Auth::id();

            if ($senderId === $receiverId) {
                throw new Exception('You cannot send a friend request to yourself.');
            }

            $existingRequest = FriendRequest::where('sender_id', $senderId)
                                            ->where('receiver_id', $receiverId)
                                            ->first();

            if ($existingRequest) {
                throw new Exception('You have already sent a friend request to this user.');
            }

            FriendRequest::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
            ]);

            return back()->with('success', 'Friend request sent successfully.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function acceptRequest($id)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($id);
            $friendRequest->delete();

            Friend::create([
                'user_id' => $friendRequest->receiver_id,
                'friend_id' => $friendRequest->sender_id,
            ]);

            return back()->with('success', 'Friend request accepted.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function declineRequest($id)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($id);
            $friendRequest->delete();

            return back()->with('success', 'Friend request declined.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelRequest($id)
    {
        try {
            $friendRequest = FriendRequest::where('sender_id', Auth::id())
                                            ->where('receiver_id', $id)
                                            ->firstOrFail();

            $friendRequest->delete();

            return back()->with('success', 'Friend request canceled.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
