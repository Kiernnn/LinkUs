<?php
namespace App\Http\Controllers;

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
        $friendRequests = FriendRequest::where('receiver_id', auth()->user()->id)
                                        ->where('status', 'pending')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)->get();
                                    //    dd($friendRequests);

        $sentRequests = FriendRequest::where('sender_id', 1)->pluck('receiver_id')->toArray();

        return view('friends.index', compact('friendRequests', 'sentRequests'));
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
}
