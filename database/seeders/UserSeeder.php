<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstName' => 'John',
            'lastName' => 'Derek',
            'userName' => 'john_derek171',
            'birthDate' => '1999-10-03',
            'gender' => 'male',
            'email' => 'johnderek@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
