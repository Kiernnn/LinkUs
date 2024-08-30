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
        $userId = auth()->user()->id;

        try {   
            $friends = Friend::with(['user', 'friend'])
                             ->where('user_id', $userId)
                             ->orWhere('friend_id', $userId)
                             ->get();

            $friendRequests = FriendRequest::with('sender')
                                           ->where('receiver_id', $userId)
                                           ->orderBy('created_at', 'desc')
                                           ->limit(5)
                                           ->get();

            $sentRequests = FriendRequest::where('sender_id', $userId)->pluck('receiver_id')->toArray();

            $suggestions = User::where('id', '!=', $userId)
                               ->inRandomOrder()
                               ->limit(5)
                               ->get(); 

            return view('friends.index', compact('friends', 'friendRequests', 'sentRequests', 'suggestions'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving the friends list: ' . $e->getMessage());
        }
    }

    public function requests()
    {
        $userId = auth()->user()->id;
        $friendRequests = FriendRequest::with('sender')
                                       ->where('receiver_id', $userId)
                                       ->get();

        return view('friends.requests', compact('friendRequests'));
    }
    
    public function unfriend($friendId)
    {
        try {
            $userId = auth()->user()->id;

            // Attempt to find the friendship in either direction
            $friendship = Friend::where(function ($query) use ($userId, $friendId) {
                $query->where('user_id', $userId)
                      ->where('friend_id', $friendId);
            })->orWhere(function ($query) use ($userId, $friendId) {
                $query->where('user_id', $friendId)
                      ->where('friend_id', $userId);
            })->first();

            if (!$friendship) {
                return back()->with('error', 'Friendship not found.');
            }

            // Delete the friendship
            $friendship->delete();

            return back()->with('success', 'Unfriend successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while removing the friend: ' . $e->getMessage());
        }
    }

    public function list()
    {
        $userId = auth()->user()->id;

        try {
            $friends = Friend::with(['user', 'friend'])
                             ->where('user_id', $userId)
                             ->orWhere('friend_id', $userId)
                             ->orderBy('created_at', 'desc')
                             ->get();

            return view('friends.list', compact('friends'));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while retrieving the friends list: ' . $e->getMessage());
        }
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');

        $searchResults = User::where('userName', 'LIKE', "%{$query}%")
                             ->where('id', '!=', auth()->user()->id)
                             ->get();

        $friends = Friend::with(['user', 'friend'])
                         ->where('user_id', auth()->user()->id)
                         ->orWhere('friend_id', auth()->user()->id)
                         ->get();

        $friendRequests = FriendRequest::with('sender')
                                       ->where('receiver_id', auth()->user()->id)
                                       ->get();
   
        $sentRequests = FriendRequest::where('sender_id', auth()->user()->id)
                                     ->pluck('receiver_id')
                                     ->toArray();

        return view('friends.index', compact('searchResults', 'friends', 'friendRequests', 'sentRequests'));
    }

    public function suggestions()
    {
        $userId = auth()->user()->id;   

        $suggestions = User::where('id', '!=', $userId)
                           ->inRandomOrder()
                           ->get();

        return view('friends.suggestions', compact('suggestions'));
    }

    public function removeSuggestion($id)
    {
        return back()->with('success', 'User removed from suggestions.');
    }
}
