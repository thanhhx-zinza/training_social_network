<?php

namespace Tests\Unit\Http\Controllers\App;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test function index when logged in
     *
     */
    public function testIndexWLoggedIn()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get('/posts');
        $response->assertOk();
        $response->assertViewIs('app.post-read');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(
            isset($data['posts'])
            && count($data['posts']) >= 0
            && count($data['posts']) <= 5
        );
    }

    /**
     * Test function create when logged out
     *
     */
    public function testIndexWLoggedOut()
    {
        $response = $this->get('/posts');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function create when logged in
     *
     */
    public function testCreate()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get('/posts/create');
        $response->assertOk();
        $response->assertViewIs('app.post-create-update');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['user']) && isset($data['audiences']));
    }

    /**
     * Test function create when logged out
     *
     */
    public function testCreateWLoggedOut()
    {
        $response = $this->get('/posts/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function store when logged out
     *
     */
    public function testStoreWLoggedOut()
    {
        Session::start();
        $response = $this->post('/posts', [
            '_token' => csrf_token(),
            'content' => 'hello world',
            'audience' => 'public',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function store successfully
     *
     * @dataProvider providerTestStoreSuccess
     */
    public function testStoreSuccess($audience)
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->post('/posts', [
            '_token' => csrf_token(),
            'content' => 'hello world',
            'audience' => $audience,
        ]);
        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'content' => 'hello world',
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * @return array
     */
    public function providerTestStoreSuccess()
    {
        return [
            ['public'],
            ['private'],
            ['onlyme'],
            ['friends']
        ];
    }

    /**
     * Test function authenticate fail in validate
     *
     * @dataProvider providerTestFailInValidate
     */
    public function testStoreFailInValidate($content, $audience)
    {
        $this->get('posts/create');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => $content,
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts/create');
    }

    /**
     * @return array
     */
    public function providerTestFailInValidate()
    {
        return [
            ['', 'public'],
            ['kkk', 'publi123'],
            ['', ''],
            [' ', ' ']
        ];
    }

    /**
     * Test function authenticate fail when is wrong audience
     *
     */
    public function testStoreFailWWrongAudience()
    {
        $user = User::first();
        $this->be($user);
        $this->get('posts/create');
        Session::start();
        $response = $this->post('/posts', [
            '_token' => csrf_token(),
            'content' => 'Hello wolrd',
            'audience' => 'kkk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts/create');
    }

    /**
     * Test function edit fail when logged in
     *
     */
    public function testEditFail()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get('posts/-1/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    /**
     * Test function edit successfully when logged in
     *
     */
    public function testEditSuccess()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::first();
        $response = $this->get('posts/'.$post->id.'/edit');
        $response->assertOk();
        $response->assertViewIs('app.post-create-update');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['user']) && isset($data['audiences']) && isset($data['post']));
        $this->assertEquals($user->id, $data['user']->id);
        $this->assertEquals($post->id, $data['post']->id);
    }

    /**
     * Test function edit when logged out
     *
     */
    public function testEditWLoggedOut()
    {
        $post = Post::first();
        $response = $this->get('posts/'.$post->id.'/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function update when logged out
     *
     */
    public function testUpdateWLoggedOut()
    {
        $post = Post::first();
        $response = $this->put('posts/'.$post->id);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function update successfully
     */
    public function testUpdateSuccess()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '=', $user->id)->first();
        Session::start();
        $response = $this->put('posts/'.$post->id, [
            '_token' => csrf_token(),
            'content' => 'fjl;asdjflkasdjflkajsdf;laksdjfl;aksdjflsakdjf;',
            'audience' => 'public',
        ]);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'content' => 'fjl;asdjflkasdjflkajsdf;laksdjfl;aksdjflsakdjf;',
            'audience' => 'public',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    /**
     * Test function authenticate fail in validate
     *
     * @dataProvider providerTestFailInValidate
     */
    public function testUpdateFailInValidate($content, $audience)
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '=', $user->id)->first();
        $response = $this->get('posts/'.$post->id.'/edit');
        Session::start();
        $response = $this->put('posts/'.$post->id, [
            '_token' => csrf_token(),
            'content' => $content,
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts/'.$post->id.'/edit');
    }

    /**
     * Test function update fail when wrong id
     *
     */
    public function testUpdateFailWWrongId()
    {
        $user = User::first();
        $this->be($user);
        Session::start();
        $response = $this->put('posts/-1', [
            '_token' => csrf_token(),
            'content' => 'hello',
            'audience' => 'kk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    /**
     * Test function update fail when wrong user_id
     *
     */
    public function testUpdateFailWWrongUserId()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '!=', $user->id)->first();
        $response = $this->get('posts/'.$post->id.'/edit');
        Session::start();
        $response = $this->put('posts/'.$post->id, [
            '_token' => csrf_token(),
            'content' => 'fjl;asdjflkasdjflkajsdf;laksdjfl;aksdjflsakdjf;',
            'audience' => 'public',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts/'.$post->id.'/edit');
    }

     /**
     * Test function update fail when wrong audience
     */
    public function testUpdateFailWWrongAudience()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '=', $user->id)->first();
        $response = $this->get('posts/'.$post->id.'/edit');
        Session::start();
        $response = $this->put('posts/'.$post->id, [
            '_token' => csrf_token(),
            'content' => 'fjl;asdjflkasdjflkajsdf;laksdjfl;aksdjflsakdjf;',
            'audience' => 'kkkk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/posts/'.$post->id.'/edit');
    }

    /**
     * Test function destroy fail when id not exists
     *
     */
    public function testDestroyFailWIdNotExists()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->delete('posts/-1');
        $response->assertStatus(302);
        $response->assertRedirect('/error');
    }

    /**
     * Test function destroy fail when wrong user_id
     *
     */
    public function testDestroyFailWWrongUserId()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '!=', $user->id)->first();
        Session::start();
        $response = $this->delete('posts/'.$post->id, [
            '_token' => csrf_token(),
            'content' => 'fjl;asdjflkasdjflkajsdf;laksdjfl;aksdjflsakdjf;',
            'audience' => 'public',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('error');
    }

    /**
     * Test function destroy when logged out
     *
     */
    public function testDestroyWLoggedOut()
    {
        $post = Post::first();
        $response = $this->delete('posts/'.$post->id);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test function destroy success
     *
     */
    public function testDestroySuccess()
    {
        $user = User::first();
        $this->be($user);
        $post = Post::where('user_id', '=', $user->id)->first();
        $response = $this->delete('posts/'.$post->id);
        $postDeleted = Post::where('id', '=', $post->id)->onlyTrashed()->first();
        $this->assertTrue($postDeleted->deleted_at != null);
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }
}
