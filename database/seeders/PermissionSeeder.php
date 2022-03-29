<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
            [
                'name' => "posts",
                'parent_id' => 0,
                'key_code' => NULL
            ],
            [
                'name' => "list",
                'parent_id' => 1,
                'key_code' => "posts_list"
            ],
            [
                'name' => "add",
                'parent_id' => 1,
                'key_code' =>"posts_add"
            ],
            [
                'name' => "edit",
                'parent_id' => 1,
                'key_code' => "posts_edit"
            ],
            [
                'name' => "delete",
                'parent_id' => 1,
                'key_code' => "posts_delete"
            ],
            [
                'name' => "admins",
                'parent_id' => 0,
                'key_code' => NULL
            ],
            [
                'name' => "list",
                'parent_id' => 6,
                'key_code' => "admins_list"
            ],
            [
                'name' => "add",
                'parent_id' => 6,
                'key_code' =>"admins_add"
            ],
            [
                'name' => "edit",
                'parent_id' => 6,
                'key_code' => "admins_edit"
            ],
            [
                'name' => "delete",
                'parent_id' => 6,
                'key_code' => "admins_delete"
            ],
            [
                'name' => "users",
                'parent_id' => 0,
                'key_code' => NULL
            ],
            [
                'name' => "list",
                'parent_id' => 11,
                'key_code' => "users_list"
            ],
            [
                'name' => "add",
                'parent_id' => 11,
                'key_code' =>"users_add"
            ],
            [
                'name' => "edit",
                'parent_id' => 11,
                'key_code' => "users_edit"
            ],
            [
                'name' => "delete",
                'parent_id' => 11,
                'key_code' => "users_delete"
            ],
            [
                'name' => "roles",
                'parent_id' => 0,
                'key_code' => NULL
            ],
            [
                'name' => "list",
                'parent_id' => 16,
                'key_code' => "roles_list"
            ],
            [
                'name' => "add",
                'parent_id' => 16,
                'key_code' =>"roles_add"
            ],
            [
                'name' => "edit",
                'parent_id' => 16,
                'key_code' => "roles_edit"
            ],
            [
                'name' => "delete",
                'parent_id' => 16,
                'key_code' => "roles_delete"
            ],
        ]);
        DB::table('permission_role')->insert([
            [
                'role_id' => 1,
                'permission_id' => 2,
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
            ],
            [
                'role_id' => 1,
                'permission_id' => 5,
            ],
            [
                'role_id' => 1,
                'permission_id' => 7,
            ],
            [
                'role_id' => 1,
                'permission_id' => 8,
            ],
            [
                'role_id' => 1,
                'permission_id' => 9,
            ],
            [
                'role_id' => 1,
                'permission_id' => 10,
            ],
            [
                'role_id' => 1,
                'permission_id' => 12,
            ],
            [
                'role_id' => 1,
                'permission_id' => 13,
            ],
            [
                'role_id' => 1,
                'permission_id' => 14,
            ],
            [
                'role_id' => 1,
                'permission_id' => 15,
            ],
            [
                'role_id' => 2,
                'permission_id' => 2,
            ],
            [
                'role_id' => 2,
                'permission_id' => 4,
            ],
            [
                'role_id' => 2,
                'permission_id' => 7,
            ],
            [
                'role_id' => 2,
                'permission_id' => 9,
            ],
            [
                'role_id' => 2,
                'permission_id' => 12,
            ],
            [
                'role_id' => 2,
                'permission_id' => 14,
            ],
            [
                'role_id' => 2,
                'permission_id' => 5,
            ],
            [
                'role_id' => 2,
                'permission_id' => 15,
            ],
            [
                'role_id' => 3,
                'permission_id' => 2,
            ],
            [
                'role_id' => 3,
                'permission_id' => 4,
            ],
            [
                'role_id' => 3,
                'permission_id' => 5,
            ],
            [
                'role_id' => 3,
                'permission_id' => 7,
            ],
            [
                'role_id' => 3,
                'permission_id' => 9,
            ],
            [
                'role_id' => 2,
                'permission_id' => 12,
            ],
            [
                'role_id' => 4,
                'permission_id' => 2,
            ],
            [
                'role_id' => 4,
                'permission_id' => 5,
            ],
            [
                'role_id' => 4,
                'permission_id' => 7,
            ],
            [
                'role_id' => 4,
                'permission_id' => 9,
            ],
            [
                'role_id' => 4,
                'permission_id' => 12,
            ],
        ]);
    }
}
