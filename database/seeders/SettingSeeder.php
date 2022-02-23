<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\User;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all();
        foreach ($user as $item) {
            $setting = new Setting();
            $setting->user_id = $item->id;
            $setting->is_noti = 1;
            $setting->is_add_friend = 1;
            $setting->save();
        }
    }
}
