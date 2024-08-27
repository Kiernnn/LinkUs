<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class FriendRequestController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Fetch friend requests
        $friendRequests = FriendRequest::where('receiver_id', $userId)
                                       ->where('status', 'pending')
                                       ->orderBy('created_at', 'desc')
                                       ->limit(5)
                                       ->get();

        // Fetch sent, received requests, and friends
        $sentRequests = FriendRequest::where('sender_id', $userId)->pluck('receiver_id')->toArray();
        $receivedRequests = FriendRequest::where('receiver_id', $userId)->pluck('sender_id')->toArray();
        $friends = Friend::where('user_id', $userId)->orWhere('friend_id', $userId)->pluck('friend_id')->toArray();

        // Exclude these users from suggestions
        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [$userId]);

        // Fetch user suggestions
        $suggestions = User::whereNotIn('id', $excludedIds)
                           ->inRandomOrder()
                           ->limit(5)
                           ->get();

        // Pass variables to the view
        return view('friends.index', compact('friendRequests', 'suggestions'));
    }

    public function sendRequest($receiverId)
    {
        $senderId = Auth::id();

        try {
            if ($senderId == $receiverId) {
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
            Log::error('Error sending friend request', ['error' => $e->getMessage()]);
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
            Log::error('Error canceling friend request', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function acceptRequest($id)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($id);

            Friend::create([
                'user_id' => $friendRequest->receiver_id,
                'friend_id' => $friendRequest->sender_id,
            ]);

            $friendRequest->delete();

            return back()->with('success', 'Friend request accepted.');
        } catch (Exception $e) {
            Log::error('Error accepting friend request', ['error' => $e->getMessage()]);
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
            Log::error('Error declining friend request', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function suggestions(Request $request)
    {
        $userId = Auth::id();
        $sentRequests = FriendRequest::where('sender_id', $userId)->pluck('receiver_id')->toArray();
        $receivedRequests = FriendRequest::where('receiver_id', $userId)->pluck('sender_id')->toArray();
        $friends = Friend::where('user_id', $userId)->orWhere('friend_id', $userId)->pluck('friend_id')->toArray();

        $excludedIds = array_merge($sentRequests, $receivedRequests, $friends, [$userId]);

        if ($request->has('all')) {
            // Show all users excluding the ones in excludedIds
            $suggestions = User::whereNotIn('id', $excludedIds)->get();
        } else {
            // Show a limited number of suggestions
            $suggestions = User::whereNotIn('id', $excludedIds)
                               ->inRandomOrder()
                               ->limit(5)
                               ->get();
        }

        return view('friends.suggestions', compact('suggestions'));
    }

    public function removeSuggestion($id)
    {
        return back()->with('success', 'User removed from suggestions.');
    }

}
