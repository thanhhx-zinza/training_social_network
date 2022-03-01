<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class PostSettingProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $settings = [];
        $profiles = [];
        $posts = [];
        foreach (DB::table('users')->orderBy('id', 'asc')->lazy(500) as $item) {
            $userId = $item->id;
            $settings[] = [
                'user_id' => $userId,
                'is_noti' => 1,
                'is_add_friend' => 1,
            ];

            $profiles[] = [
                'user_id' => $userId,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'address' => $faker->address(),
                'gender' => array_rand(array_flip(Profile::getGenders())),
                'birthday' => $faker->dateTime(),
                'phone_number' => $faker->e164PhoneNumber(),
            ];

            for ($i = 0; $i < 10; $i++) {
                $posts[] = [
                    'user_id' => $userId,
                    'content' => $faker->text(240),
                    'audience' => 'public',
                    'display' => 1,
                ];
            }
        }
        Setting::upsert($settings, ['id']);
        Profile::upsert($profiles, ['id']);
        Post::upsert($posts, ['id']);
    }
}
