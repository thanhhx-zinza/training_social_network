<?php

namespace Tests\Unit\Http\Controllers\App;

use Tests\TestCase;
use App\Models\User;
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
        $response = $this->get('/post');
        $response->assertOk();
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['user']) && isset($data['audiences']));
    }

    /**
     * Test function index when logged out
     *
     */
    public function testIndexWLoggedOut()
    {
        $response = $this->get('/post');
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
        $response = $this->post('/post', [
            '_token' => csrf_token(),
            'content' => 'hello world',
            'audience' => $audience,
        ]);
        $this->assertDatabaseHas('posts', [
            'users_id' => $user->id,
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
     * @dataProvider providerTestStoreFailInValidate
     */
    public function testStoreFailInValidate($content, $audience)
    {
        $this->get(route('post.index'));
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => $content,
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post');
    }

    /**
     * @return array
     */
    public function providerTestStoreFailInValidate()
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
        $this->get(route('post.index'));
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => 'Hello wolrd',
            'audience' => 'kkk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post');
    }
}
