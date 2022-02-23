<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $post = Post::first();
        Comment::factory()->count(5)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }
}
