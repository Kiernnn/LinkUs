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
    }

    public function sendRequest(Request $request)
    {
        try {
            $existingRequest = FriendRequest::where('sender_id', auth()->user()->id)
                                            ->where('receiver_id', $request->receiverId)
                                            ->where('status', 'pending')
                                            ->first();

            if ($existingRequest) {
                throw new Exception('You have already sent a friend request to this user.');
            }

            FriendRequest::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiverId,
            ]);

            return response()->json(['message' => 'Friend Request Sent'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error senting friend request', 'error' => $e->getMessage()], 500);
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

            return back()->with('success', 'Friend request canceled.');
        } catch (Exception $e) {

            return back()->with('error', $e->getMessage());
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

            return response()->json(['message' => 'Friend request Accepted'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error accepting friend request', 'error' => $e->getMessage()], 500);
        }
    }

    public function declineRequest(Request $request)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($request->reqId);
            $friendRequest->delete();

            return response()->json(['message' => 'Friend request Declined'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error rejecting friend request', 'error' => $e->getMessage()], 500);
        }
    }

    public function suggestions(Request $request)
    {
        $userId = auth()->user()->id;
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
