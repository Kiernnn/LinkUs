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


        $sentRequests = FriendRequest::where('sender_id', auth()->user()->id)->pluck('receiver_id')->toArray();
        $receivedRequests = FriendRequest::where('receiver_id', auth()->user()->id)->pluck('sender_id')->toArray();
        
        $friends = Friend::where('user_id', auth()->user()->id)
            ->orWhere('friend_id', auth()->user()->id)
            ->pluck('friend_id')
            ->toArray();

        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [auth()->user()->id]);

        $friendsOfFriends = Friend::whereIn('user_id', $friends)
           ->orWhereIn('friend_id', $friends)
           ->pluck('friend_id')
           ->toArray();

        if(empty($friendsOfFriends)) {
            $suggestions = User::whereNotIn('id', $excludedIds)
                ->inRandomOrder()
                ->limit(5)
                ->get();
        } else {
            $suggestions = User::whereIn('id', array_diff($friendsOfFriends, $excludedIds))
                ->inRandomOrder()
                ->limit(5)
                ->get();
        }

        return view('friend-requests.index', compact('friendRequests', 'suggestions', 'sentRequests', 'receivedRequests', 'friends'));
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
        $request->validate([
            'receiverId' => 'required|exists:users,id', 
        ]);

        try {
            // if ($request->receiverId == auth()->user()->id) {
            //     return response()->json(['message' => 'You cannot send a friend request to yourself.'], 400);
            // }

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
            $friendRequest = FriendRequest::where('sender_id', auth()->user()->id)
                ->where('receiver_id', $id)
                ->where('status', 'pending')
                ->firstOrFail();

            $friendRequest->delete();

            $receivedRequest = FriendRequest::where('sender_id', $id)
                ->where('receiver_id', auth()->user()->id)
                ->where('status', 'pending')
                ->first();

            if ($receivedRequest) {
                $receivedRequest->delete();
            }

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
            
            Friend::create([
                'user_id' => $friendRequest->sender_id,
                'friend_id' => $friendRequest->receiver_id,
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
            $friendRequest = FriendRequest::find($id);

            if (!$friendRequest) {
                return response()->json(['message' => 'Friend request not found'], 404);
            }

            Friend::where('user_id', $friendRequest->receiver_id)
                  ->where('friend_id', $friendRequest->sender_id)
                  ->delete();

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

        if(!empty($friends)) {
            $friendsOfFriends = Friend::whereIn('user_id', $friends)
                                       ->orWhereIn('friend_id', $friends)
                                       ->pluck('friend_id')
                                       ->toArray();

            $friendsOfFriends = array_merge($friendsOfFriends, Friend::whereIn('friend_id', $friends)->pluck('user_id')->toArray());
        } else {
            $friendsOfFriends = [];
        }
        
        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [auth()->user()->id]);

        if(empty($friendsOfFriends)) {
            $suggestions = User::whereNotIn('id', $excludedIds)
               ->inRandomOrder()
               ->limit(10)
               ->get();
        } else {
            if ($request->has('all')) {
                $suggestions = User::whereIn('id', array_diff($friendsOfFriends, $excludedIds))->get();
            } else {
                $suggestions = User::whereIn('id', array_diff($friendsOfFriends, $excludedIds))
                                   ->inRandomOrder()
                                   ->get();
            }
        }
        
        return view('friend-requests.suggestions', compact('suggestions'));
    }

    public function count()
    {
        $friendRequestCount = FriendRequest::where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return response()->json(['count' => $friendRequestCount]);
    }

}
