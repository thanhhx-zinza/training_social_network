<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Post;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test function index when logged in
     */
    public function testStoreWithPostNotPublic()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $user->posts()->create([
            'content' => 'content',
            'audience' => 'private',
            'display' => 1
        ]);
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
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->post('/posts/' . Post::first()->id . '/comments', [
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
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->put('/posts/' . Post::first()->id . '/comments/' . Comment::first()->id, [
            '_token' => csrf_token(),
            'content' => 'thank you everyone',
        ]);
        $this->assertDatabaseHas('comments', [
            'content' => 'thank you everyone',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function testEditWithCommentOfOtherUser()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $user = User::skip(1)->first();
        $user->comments()->create([
            'post_id' => Post::first()->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
        $comment = Comment::orderBy('id', 'desc')->first();
        $response = $this->get('/posts/' . Post::first()->id . '/comments/' . $comment->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    public function testEditSuccess()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->get('/posts/' . Post::first()->id . '/comments/' . Comment::first()->id . '/edit');
        $response->assertStatus(200);
    }

    public function testDestroySuccess()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->delete('/posts/' . Post::first()->id . '/comments/' . Comment::first()->id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
    }
}
