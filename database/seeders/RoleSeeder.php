<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
           ['name' => "Master"],
           ['name' => "Manager"],
           ['name' => "Editor"],
           ['name' => "Reviewer"],
        ]);
        DB::table('admin_role')->insert([
            [
                'admin_id' => 1,
                'role_id' => 1,
            ],
            [
                'admin_id' => 2,
                'role_id' => 2,
            ],
            [
                'admin_id' => 3,
                'role_id' => 3,
            ],
            [
                'admin_id' => 4,
                'role_id' => 4,
            ],
        ]);
    }
}
