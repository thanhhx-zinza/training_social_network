<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $post = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'Hello world',
            'previous_id' => -1,
            'level' => 1,
        ];
    }
}
