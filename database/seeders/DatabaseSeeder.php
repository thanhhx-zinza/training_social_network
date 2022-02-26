<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Model seeder create users. posts. setting, profiles, relations
         */
        $this->call([
            ModelSeeder::class,
        ]);
    }
}
