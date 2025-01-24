<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;
use App\Http\Controllers\FriendRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FriendsController extends Controller
{
    public function index()
    {
        try {
            $viewingUser = auth()->user();

            // $friends = Friend::with(['user', 'friend'])
            //                  ->where('user_id', $viewingUser->id)
            //                  ->orWhere('friend_id', $viewingUser->id)
            //                  ->get()
            //                  ->unique(function ($friend) use ($viewingUser) {
            //                     // Group by the friend user, ignoring the direction of the friendship
            //                     return $friend->user_id == $viewingUser->id ? $friend->friend_id : $friend->user_id;
            //                 });
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

            $friendRequests = FriendRequest::with('sender')
                                           ->where('receiver_id', $viewingUser->id)
                                           ->orderBy('created_at', 'desc')
                                           ->limit(5)
                                           ->get();

            $sentRequests = FriendRequest::where('sender_id', $viewingUser->id)->pluck('receiver_id')->toArray();

            $suggestions = User::where('id', '!=', $viewingUser->id)
                               ->inRandomOrder()
                               ->limit(5)
                               ->get();

            return view('friends.index', compact('viewingUser', 'friends', 'friendRequests', 'sentRequests', 'suggestions'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving the friends list: ' . $e->getMessage());
        }
    }

    public function showFriends($userId)
    {
        try {
            $viewingUser = User::findOrFail($userId);

            $friends = Friend::with(['user', 'friend'])
                             ->where('user_id', $userId)
                             ->orWhere('friend_id', $userId)
                             ->orderBy('created_at', 'desc')
                             ->get();

            return view('friends.index', compact('friends', 'viewingUser'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving the friends list: ' . $e->getMessage());
        }
    }

    public function unfriend($friendId)
    {
        try {
            $userId = auth()->user()->id;

            $friendship = Friend::where(function ($query) use ($userId, $friendId) {
                $query->where('user_id', $userId)
                      ->where('friend_id', $friendId);
            })->orWhere(function ($query) use ($userId, $friendId) {
                $query->where('user_id', $friendId)
                      ->where('friend_id', $userId);
            })->first();

            if (!$friendship) {
                return response()->json(['message' => 'Friendship not found.'], 404);
            }

            // foreach ($friendship as $record) {
            //     $record->delete();
            // }
            $friendship->delete();

            return response()->json(['message' => 'Unfriended successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while removing the friend: ' . $e->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $viewingUser = auth()->user();

            $friends = Friend::with(['user', 'friend'])
                             ->where('user_id', $viewingUser->id )
                             ->orWhere('friend_id', $viewingUser->id )
                             ->orderBy('created_at', 'desc')
                             ->get()
                             ->unique(function ($friend) use ($viewingUser) {
                                // Group by the friend user, ignoring the direction of the friendship
                                return $friend->user_id == $viewingUser->id ? $friend->friend_id : $friend->user_id;
                            });

            return view('friends.index', compact('viewingUser', 'friends'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving the friends list: ' . $e->getMessage());
        }
    }
}
