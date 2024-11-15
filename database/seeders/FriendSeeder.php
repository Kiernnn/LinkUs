<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;
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

        $userId = 2;

        for ($i = 0; $i < 5; $i++) {
            do {
                $friendId = $userIds[array_rand($userIds)];
            } while (
                $friendId === $userId ||
                
                Friend::where('user_id', $userId)->where('friend_id', $friendId)->exists());

            Friend::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
            ]);

            Friend::create([
                'user_id' => $friendId,
                'friend_id' => $userId,
            ]);
        }
    }
}
