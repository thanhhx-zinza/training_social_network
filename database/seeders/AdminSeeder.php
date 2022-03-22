<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin')->insert([
            'name' => "Adminstrators",
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678),
            "level" => 0
        ]);
    }
}
