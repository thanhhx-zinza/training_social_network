<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class RelationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = array_flip(['friend', 'request']);
        $user = User::inRandomOrder()->first();
        $friendIds = $user->friends()->pluck(['id']);
        $requestIds = $user->requestUsers()->pluck(['id']);
        $arr = $friendIds->merge($requestIds);
        $stranger = User::where('id', '!=', $user->id)
            ->openAdd()
            ->whereNotIn('id', $arr)
            ->inRandomOrder()
            ->first();
        return [
            'user_id' => $user->id,
            'friend_id' => $stranger->id,
            'type' => array_rand($types),
        ];
    }

    /**
     * Create relation which user send request
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function requestedBy(User $user, $type)
    {
        return $this->state(function (array $attributes) use($user, $type) {
            $friendIds = $user->friends()->pluck(['id']);
            $requestIds = $user->requestUsers()->pluck(['id']);
            $arr = $friendIds->merge($requestIds);
            $stranger = User::where('id', '!=', $user->id)
                ->openAdd()
                ->whereNotIn('id', $arr)
                ->inRandomOrder()
                ->first();
            return [
                'user_id' => $user->id,
                'friend_id' => $stranger->id,
                'type' => $type,
            ];
        });
    }

    /**
     * Create relation which user take request
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function requestTo(User $user, $type)
    {
        return $this->state(function (array $attributes) use($user, $type) {
            $friendIds = $user->friends()->pluck(['id']);
            $requestIds = $user->requestUsers()->pluck(['id']);
            $arr = $friendIds->merge($requestIds);
            $stranger = User::where('id', '!=', $user->id)
                ->openAdd()
                ->whereNotIn('id', $arr)
                ->inRandomOrder()
                ->first();
            return [
                'user_id' => $stranger->id,
                'friend_id' => $user->id,
                'type' => $type,
            ];
        });
    }
}
