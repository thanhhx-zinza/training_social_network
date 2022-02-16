<?php

namespace Tests\Unit\Http\Controllers\App;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @return void
     */
    // protected function setUp(): void
    // {
    //     $user = User::first();
    //     $this->be($user);
    // }

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
            ['only-me'],
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
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => $content,
            'audience' => $audience,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
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
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'content' => 'Hello wolrd',
            'audience' => 'kkk',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
