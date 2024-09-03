<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FriendRequestController extends Controller
{
    public function index()
    {
        $friendRequests = FriendRequest::where('receiver_id', auth()->user()->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Fetch sent, received requests, and friends
        $sentRequests = FriendRequest::where('sender_id', auth()->user()->id)->pluck('receiver_id')->toArray();
        $receivedRequests = FriendRequest::where('receiver_id', auth()->user()->id)->pluck('sender_id')->toArray();
        $friends = Friend::where('user_id', auth()->user()->id)->orWhere('friend_id', auth()->user()->id)->pluck('friend_id')->toArray();

        // Exclude these users from suggestions
        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [auth()->user()->id]);

        // Fetch user suggestions
        $suggestions = User::whereNotIn('id', $excludedIds)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        // Pass variables to the view
        return view('friend-requests.index', compact('friendRequests', 'suggestions'));
        // if ($someCondition) {
        //     return view('friend-requests.requests', compact('friendRequests'));
        // } else {
        //     return view('friend-requests.suggestions', compact('suggestions'));
        // }
    }

    public function requests()
    {
        $friendRequests = FriendRequest::with('sender')
                                       ->where('receiver_id', auth()->user()->id)
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        return view('friend-requests.requests', compact('friendRequests'));
    }

    public function sendRequest(Request $request)
    {
        try {
            $existingRequest = FriendRequest::where('sender_id', auth()->user()->id)
                ->where('receiver_id', $request->receiverId)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                throw new Exception('You have already sent a friend request.');
            }

            FriendRequest::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiverId,
            ]);

            return response()->json(['message' => 'Friend Request Sent'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error sending friend request', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancelRequest($id)
    {
        try {
            // Retrieve the friend request based on sender_id and receiver_id
            $friendRequest = FriendRequest::where('sender_id', auth()->user()->id)
                ->where('receiver_id', $id)
                ->where('status', 'pending')
                ->firstOrFail();

            // Delete the friend request
            $friendRequest->delete();

            return response()->json(['message' => 'Friend Request Cancelled'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error Cancelling Friend Request.', 'error' => $e->getMessage()], 500);
        }
    }


    public function acceptRequest(Request $request)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($request->reqId);

            Friend::create([
                'user_id' => $friendRequest->receiver_id,
                'friend_id' => $friendRequest->sender_id,
            ]);

            $friendRequest->delete();

            return response()->json(['message' => 'You are now friends.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error accepting friend request', 'error' => $e->getMessage()], 500);
        }
    }

    public function declineRequest(Request $request, $id)
    {
        try {
            // Fetch the FriendRequest by its primary key 'id'
            $friendRequest = FriendRequest::find($id);

            if (!$friendRequest) {
                return response()->json(['message' => 'Friend request not found'], 404);
            }

            // Remove the friendship if it exists
            Friend::where('user_id', $friendRequest->receiver_id)
                  ->where('friend_id', $friendRequest->sender_id)
                  ->delete();

            // Delete the friend request
            $friendRequest->delete();

            return response()->json(['message' => 'Friend Request Declined.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error rejecting friend request', 'error' => $e->getMessage()], 500);
        }
    }

    public function suggestions(Request $request)
    {
        $sentRequests = FriendRequest::where('sender_id', auth()->user()->id)->pluck('receiver_id')->toArray();
        $receivedRequests = FriendRequest::where('receiver_id', auth()->user()->id)->pluck('sender_id')->toArray();
        $friends = Friend::where('user_id', auth()->user()->id)->orWhere('friend_id', auth()->user()->id)->pluck('friend_id')->toArray();

        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [auth()->user()->id]);

        if ($request->has('all')) {
            // Show all users excluding the ones in excludedIds
            $suggestions = User::whereNotIn('id', $excludedIds)->get();
        } else {
            // Show a limited number of suggestions
            $suggestions = User::whereNotIn('id', $excludedIds)
                               ->inRandomOrder()
                               ->get();
        }
        return view('friends.suggestions', compact('suggestions'));
    }
}
