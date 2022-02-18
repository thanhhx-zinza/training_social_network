<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        $user = User::first();
        return [
            'user_id' => $user->id,
            'content' => 'Hello world',
            'audience' => 'public',
            'display' => 1,
        ];
    }
}
