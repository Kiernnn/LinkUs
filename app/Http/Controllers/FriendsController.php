<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;

class FriendsController extends Controller
{
    public function index(){
        $userId = auth()->user()->id;
        $friends = Friend::where('user_id', $userId)->orWhere('friend_id', $userId)->get();
        return view('friends.index', compact('friends'));
    }

    public function unfriend($friendId)
    {
        $userId = auth()->user()->id;

        Friend::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                  ->where('friend_id', $userId);
        })->delete();

        return redirect()->back()->with('success', 'Unfriended successfully.');
    }
}
