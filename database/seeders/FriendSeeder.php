<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::pluck('id')->toArray();

        // Example user_id
        $userId = 1;

        // Create random friends for the user
        for ($i = 0; $i < 5; $i++) {
            // Get a random friend_id that is not the same as user_id and not already a friend
            do {
                $friendId = $userIds[array_rand($userIds)];
            } while ($friendId === $userId || Friend::where('user_id', $userId)->where('friend_id', $friendId)->exists());

            Friend::create(['user_id' => $userId, 'friend_id' => $friendId]);
        }
    }
}
