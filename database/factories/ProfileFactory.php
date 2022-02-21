<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'address' => 'address',
            'gender' => 'gender',
            'birthday' => '1990-01-01',
            'phone_number' => '123456789'
        ];
    }
}
