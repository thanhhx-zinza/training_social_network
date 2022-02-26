<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Relation;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
            ->count(50)
            ->has(
                Post::factory()
                    ->count(10)
                    ->has(Comment::factory()->count(5))
            )
            ->create();

        foreach ($users as $user) {
            Relation::factory()->count(5)->requestedBy($user, 'friend')->create();
            Relation::factory()->count(5)->requestTo($user, 'request')->create();
        }
    }
}
