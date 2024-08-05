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
            'firstName' => 'Victor',
            'lastName' => 'Kobayashi',
            'userName' => 'victor234',
            'birthDate' => '2003-08-20',
            'gender' => 'male',
            'email' => 'victor@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
