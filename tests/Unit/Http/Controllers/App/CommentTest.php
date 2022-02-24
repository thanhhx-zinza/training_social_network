<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Post;
use Faker\Factory;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public $newUser;

    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $faker = Factory::create();
        $this->newUser = User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->name()
        ]);
        $this->newPost = Post::create([
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'content' => $faker->name,
            'display' => $faker->randomNumber(2),
            'audience' => 'public'
        ]);
        $this->comment = [
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'post_id' => Post::orderBy('id', 'desc')->first()->id,
            'previous_id' => -1,
            'level' => 1,
            'content' => $faker->name
        ];
        $this->new = Comment::create($this->comment);
    }

    public function testStoreWithPostNotPublic()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $post = Post::orderBy('id', 'desc')->first();
        $post->audience = 'private';
        $post->save();
        $response = $this->post('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments', [
            '_token' => csrf_token(),
            'post_id' => Post::orderBy('id', 'desc')->first()->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    public function testStoreSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $response = $this->post('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments', [
            '_token' => csrf_token(),
            'post_id' => Post::first()->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testUpdateSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $response = $this->put('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments/' . Comment::orderBy('id', 'desc')->first()->id, [
            '_token' => csrf_token(),
            'content' => 'thank you everyone'
        ]);
        $this->assertDatabaseHas('comments', [
            'content' => 'thank you everyone'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testEditWithCommentOfOtherUser()
    {
        $faker = Factory::create();
        $user = User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->name()
        ]);
        $this->be($user);
        Session::start();
        $response = $this->get('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments/' . Comment::orderBy('id', 'desc')->first()->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    public function testEditSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $response = $this->get('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments/' . Comment::orderBy('id', 'desc')->first()->id . '/edit');
        $response->assertStatus(200);
    }

    public function testDestroyWithCommentOfOtherUser()
    {
        $faker = Factory::create();
        $user = User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->name()
        ]);
        $this->be($user);
        Session::start();
        $user = $this->newUser;
        $user->comments()->create([
            'post_id' => Post::orderBy('id', 'desc')->first()->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
        $response = $this->delete('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments/' . Comment::orderBy('id', 'desc')->first()->id, ['_token' => csrf_token()]);
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    public function testDestroySuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $response = $this->delete('/posts/' . Post::orderBy('id', 'desc')->first()->id . '/comments/' . Comment::orderBy('id', 'desc')->first()->id, ['_token' => csrf_token()]);
        $response->assertStatus(302);
    }
}
