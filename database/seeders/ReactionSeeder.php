<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use Illuminate\Support\Facades\DB;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->orderBy('id', 'asc')->chunk(2000, function ($comments) {
            $reactions = [];
            foreach ($comments as $item) {
                for ($i = 0; $i < 5; $i++) {
                    $reactions[] = [
                        'user_id' => DB::table('users')->inRandomOrder()->first()->id,
                        'reactiontable_id' => $item->id,
                        'reactiontable_type' => 'App\Models\Comment',
                        'type' => 'like',
                    ];
                }
            }
            Reaction::upsert($reactions, ['id']);
        });
    }
}
