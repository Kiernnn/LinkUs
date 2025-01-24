<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'content' => ucfirst(Str::limit($this->faker->sentence, 20)), 
            'status' => $this->faker->randomElement(['public', 'friends', 'me']), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
