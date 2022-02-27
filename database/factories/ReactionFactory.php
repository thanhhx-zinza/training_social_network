<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $post = Post::isPublic()->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'reactiontable_id' => $post->id,
            'reactiontable_type' => 'App\Models\Post',
            'type' => 'like',
        ];
    }
}
