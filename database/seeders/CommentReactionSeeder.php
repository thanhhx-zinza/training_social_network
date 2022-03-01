<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Reaction;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CommentReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('posts')->orderBy('id', 'asc')->chunk(1000, function ($posts) use($faker) {
            $reactions = [];
            $comments = [];
            foreach ($posts as $item) {
                for ($i = 0; $i < 10; $i++) {
                    $reactions[] = [
                        'user_id' => DB::table('users')->inRandomOrder()->first()->id,
                        'reactiontable_id' => $item->id,
                        'reactiontable_type' => 'App\Models\Post',
                        'type' => 'like',
                    ];
                }
                $userId = DB::table('users')->inRandomOrder()->first()->id;
                for ($i = 0; $i < 5; $i++) {
                    $comments[] = [
                        'user_id' => $userId,
                        'post_id' => $item->id,
                        'content' => $faker->text(250),
                        'previous_id' => -1,
                        'level' => 1,
                    ];
                }
            }
            Reaction::upsert($reactions, ['id']);
            Comment::upsert($comments, ['id']);
        });
    }
}
