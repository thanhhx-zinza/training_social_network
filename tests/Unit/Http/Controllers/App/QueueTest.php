<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Job;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Reaction;
use Faker\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QueueTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Test function index when logged in
     */

    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $faker = Factory::create();
        $this->post('register', [
            '_token' => csrf_token(),
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => '123456789',
        ]);
        $user = User::orderBy('id', 'desc')->first();
        $this->newPost = $user->posts()->create([
            'content' => $faker->name,
            'display' => $faker->randomNumber(2),
            'audience' => 'public',
        ]);
        Profile::create([
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'address' => $faker->address,
            'gender' => $faker->randomElement(['male', 'female']),
            'birthday' => $faker->datetime(),
            'phone_number' => $faker->phonenumber,
        ]);
    }

    public function testUpdatePointSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $post = Post::orderBy('id', 'desc')->first();
        $result = $post->total_reactions_count + 1;
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        $response = $this->post('/reactions', [
            'user_id' => $user->id,
            'reaction_table_id' => $post->id,
            'type' => 'like',
            'reaction_table_type' => 'App\Models\Post',
        ]);
        $reaction = Reaction::orderBy('id', 'desc')->first();
        $post = Post::orderBy('id', 'desc')->first();
        $this->assertTrue($result === $post->total_reaction_count);
    }
}
