<?php

namespace Tests\Unit\Http\Controllers\App;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Post;
use Faker\Factory;

class ReactionTest extends TestCase
{
    use DatabaseTransactions;

    public $newUser;
    public $newPost;

    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $faker = Factory::create();
        $this->newUser = User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->name(),
        ]);
        $this->newPost = Post::create([
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'content' => $faker->name,
            'display' => $faker->randomNumber(2),
            'audience' => 'public',
        ]);
    }

    public function testStoreSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $post = Post::orderBy('id', 'desc')->first();
        $response = $this->post('/posts/' . $post->id . '/reactions', [
            '_token' => csrf_token(),
            'post_id' => $post->id,
            'comment_id' => -1,
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testUpdateSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        $post = Post::orderBy('id', 'desc')->first();
        Session::start();
        $user->reactions()->create([
            'post_id' => $post->id,
            'comment_id' => -1,
            'type' => 'unlike'
        ]);
        $response = $this->post('/posts/' . $post->id . '/reactions', [
            '_token' => csrf_token(),
            'post_id' => $post->id,
            'comment_id' => -1,
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testDeleteSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        $post = Post::orderBy('id', 'desc')->first();
        Session::start();
        $user->reactions()->create([
            'post_id' => $post->id,
            'comment_id' => -1,
            'type' => 'like'
        ]);
        $response = $this->post('/posts/' . $post->id . '/reactions', [
            '_token' => csrf_token(),
            'post_id' => $post->id,
            'comment_id' => -1,
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }
}
