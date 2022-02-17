<?php

namespace Tests\Unit\Http\Controllers\App;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Post;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test function create when logged in
     *
     */
    public function testCreateWLoggedIn()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get('/post/create');
        $response->assertOk();
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['user']) && isset($data['audiences']));
    }

    /**
     * Test function create when logged out
     *
     */
    public function testCreateWLoggedOut()
    {
        $response = $this->get('/post/create');
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
     * @dataProvider providerTestStoreFailInValidate
     */
    public function testStoreFailInValidate($content, $audience)
    {
        $this->get('post/create');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => $content,
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post/create');
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
        $this->get('post/create');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => 'Hello wolrd',
            'audience' => 'kkk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/post/create');
    }
}
