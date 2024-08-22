<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FriendsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        try {
            $friends = Friend::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('friend_id', $userId);
            })
            ->with(['user', 'friend'])
            ->get();

            $friendRequests = FriendRequest::where('receiver_id', $userId)
                                           ->with('sender')
                                           ->get();

            $sentRequests = FriendRequest::where('sender_id', $userId)->pluck('receiver_id')->toArray();

            return view('friends.index', compact('friends', 'friendRequests', 'sentRequests'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving friends list: ' . $e->getMessage());
        }
    }

    public function unfriend($friendId)
    {
        try {
            $userId = Auth::id();

            // Find the friendship regardless of who is user_id or friend_id
            $friendship = Friend::where(function($query) use ($userId, $friendId) {
                $query->where('user_id', $userId)->where('friend_id', $friendId)
                      ->orWhere('user_id', $friendId)->where('friend_id', $userId);
            })->first();

            if (!$friendship) {
                throw new Exception('Friendship not found.');
            }

            $friendship->delete();

            return back()->with('success', 'Friend removed successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while removing friend: ' . $e->getMessage());
        }
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $searchResults = User::where('userName', 'LIKE', "%{$query}%")
                             ->where('id', '!=', Auth::id())
                             ->get();

        $friends = Friend::where('user_id', Auth::id())
                         ->orWhere('friend_id', Auth::id())
                         ->with(['user', 'friend'])
                         ->get();

        $friendRequests = FriendRequest::where('receiver_id', Auth::id())
                                       ->with('sender')
                                       ->get();

        $sentRequests = FriendRequest::where('sender_id', Auth::id())
                                     ->pluck('receiver_id')
                                     ->toArray();

        return view('friends.index', compact('searchResults', 'friends', 'friendRequests', 'sentRequests'));
    }

}
