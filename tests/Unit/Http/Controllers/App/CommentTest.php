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
     *
     */
    public function testStoreSuccess()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->post('/comment/store', [
            '_token' => csrf_token(),
            'user_id' => $user->id,
            'post_id' => Post::first()->id,
            'previous_id' => Comment::first()->id,
            'content' => 'hello world',
            'level' => 1
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => Post::first()->id,
            'previous_id' => Comment::first()->id,
            'content' => 'hello world',
            'level' => 1
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post');
    }

    public function testUpdateSuccess()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->post('/comment/update', [
            '_token' => csrf_token(),
            'id' => Comment::first()->id,
            'content' => 'hello world'
        ]);
        $this->assertDatabaseHas('comments', [
            'content' => 'hello world'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post');
    }
    
    public function testEdit()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->post('/comment/edit', ['id' => $user->comments->first()->id]);
        $response->assertStatus(200);
    }
}
