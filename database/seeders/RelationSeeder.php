<?php

namespace Database\Seeders;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userFirst = User::orderBy("id", "asc")->first();
        $userLast = User::orderBy("id", "desc")->first();
        Relation::insert([
         ["user_id" => $userLast->id, "friend_id" => $userFirst->id,"type" => "request"],
         ["friend_id" => $userLast->id, "user_id" => $userFirst->id,"type" => "friend"],
        ]);
    }
}
