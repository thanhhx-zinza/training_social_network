<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::limit(3)->get();
        foreach ($users as $user) {
            Post::factory()->count(5)->create(['user_id' => $user->id]);
        }
    }
}
