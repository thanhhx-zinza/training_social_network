<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Relation;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::chunk(1000, function ($users) {
            $relations = [];
            foreach ($users as $user) {
                $friendIds = $user->friends()->pluck(['id']);
                $requestIds = $user->requestUsers()->pluck(['id']);
                $arr = $friendIds->merge($requestIds);
                $strangers = DB::table('users')->where('id', '!=', $user->id)
                    ->whereNotIn('id', $arr)
                    ->limit(10)
                    ->get();
                $i = 0;
                foreach ($strangers as $stranger) {
                    if ($i < floor($strangers->count() / 2)) {
                        $relations[] = [
                            'user_id' => $user->id,
                            'friend_id' => $stranger->id,
                            'type' => 'friend',
                        ];
                    } else {
                        $relations[] = [
                            'user_id' => $stranger->id,
                            'friend_id' => $user->id,
                            'type' => 'request',
                        ];
                    }
                    $i++;
                }
            }
            Relation::upsert($relations, ['id']);
        });
    }
}
