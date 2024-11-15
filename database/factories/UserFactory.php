<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'userName' => $this->faker->unique()->userName,
            'birthDate' => $this->faker->date,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'email' => preg_replace('/@example\..*/', '@gmail.com', $this->faker->unique()->safeEmail),
            'email_verified_at' => now(),
            'password' =>  Hash::make('password'),
            'remember_token' => Str::random(20),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
