<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Comment;
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
        $user = User::orderBy('id', 'desc')->first();
        $this->newPost = $user->posts()->create([
            'content' => $faker->name,
            'display' => $faker->randomNumber(2),
            'audience' => 'public',
        ]);
        $post = Post::orderBy('id', 'desc')->first();
        $this->newComment = $user->comments()->create([
            'post_id' => $post->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
    }

    public function testStoreLikePostSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $post = Post::orderBy('id', 'desc')->first();
        $response = $this->post('/reactions', [
            '_token' => csrf_token(),
            'reaction_table_id' => $post->id,
            'reaction_table_type' => 'App\Models\Post',
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testStoreLikeCommentSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $comment = Comment::orderBy('id', 'desc')->first();
        $response = $this->post('/reactions', [
            '_token' => csrf_token(),
            'reaction_table_id' => $comment->id,
            'reaction_table_type' => 'App\Models\Comment',
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testDestroyLikePostSuccess()
    {
        $user = User::orderBy('id', 'desc')->first();
        $this->be($user);
        Session::start();
        $post = Post::orderBy('id', 'desc')->first();
        $reaction = $user->reactions()->create([
            'reactiontable_id' => $post->id,
            'type' => 'like',
            'reactiontable_type' => 'App\Models\Post',
        ]);
        $response = $this->delete('/reactions/' . $reaction->id, [
            '_token' => csrf_token(),
            'reaction_table_id' => $post->id,
            'type' => 'like'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }
}
