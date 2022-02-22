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
        $response = $this->post('/comment', [
            '_token' => csrf_token(),
            'post_id' => Post::first()->id,
            'previous_id' => -1,
            'content' => 'hello world',
            'level' => 1
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => Post::first()->id,
            'previous_id' => -1,
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
        $response = $this->put('/comment/' . Comment::first()->id, [
            '_token' => csrf_token(),
            'content' => 'thank you everyone'
        ]);
        $this->assertDatabaseHas('comments', [
            'content' => 'thank you everyone'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post');
    }
    
    public function testEdit()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->get('/comment/' . Comment::first()->id . '/edit');
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->delete('/comment/' . Comment::first()->id);
        $response->assertStatus(302);
    }
}
