<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Friend;
use App\Enums\RequestStatus;

class FriendRequestSeeder extends Seeder
{
    public function run()
    {
        $receiverId = 1;
        $existingRequests = FriendRequest::where('receiver_id', $receiverId)->count();

        if ($existingRequests < 10) {
            $remainingRequests = 10 - $existingRequests;
            
            for ($i = 0; $i < $remainingRequests; $i++) {
                $senderId = User::where('id', '!=', $receiverId)->inRandomOrder()->first()->id;

                $friendsWith = Friend::where(function($query) use ($senderId, $receiverId) {
                    $query->where('user_id', $senderId)
                          ->where('friend_id', $receiverId);
                })->orWhere(function($query) use ($senderId, $receiverId) {
                    $query->where('user_id', $receiverId)
                          ->where('friend_id', $senderId);
                })->exists();

                if ($friendsWith) {
                    continue; 
                }

                $exists = FriendRequest::where('sender_id', $senderId)
                                        ->where('receiver_id', $receiverId)
                                        ->exists();

                if (!$exists) {
                    FriendRequest::create([
                        'sender_id' => $senderId,
                        'receiver_id' => $receiverId,
                        'status' => RequestStatus::PENDING->value,
                    ]);
                }
            }
        }
    }
}
