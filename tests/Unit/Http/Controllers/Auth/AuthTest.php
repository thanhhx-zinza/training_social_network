<?php

namespace Tests\Unit\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test function login success
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    /**
     * Test function authenticate successfully
     *
     * @return void
     */
    public function testAuthenticateSuccess()
    {
        Session::start();
        $user = User::first();
        $faker = Factory::create();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => 12345678,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/");
    }

    public function testLoginWithoutProfile()
    {
        $this->markTestSkipped('The MySQLi extension is not available.');
        Session::start();
        $faker = Factory::create();
        $data = [
            'name' => $faker->name,
            'password' => Hash::make(12345678),
            'email' => $faker->email,
        ];
        $user = User::insert($data);
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => User::orderBy('id', 'DESC')->first()->email,
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/profile/edit");
    }

    /**
     * Test function authenticate fail in validate
     *
     * @param string $email
     * @param string $password
     *
     * @dataProvider providerTestAuthenticateFailInValidate
     */
    public function testAuthenticateFailInValidate($email, $password)
    {
        $response = $this->get('/login');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Provider for function testAuthenticateFailInValidate()
     *
     * @return array
     */
    public function providerTestAuthenticateFailInValidate()
    {
        return [
            ['', '12345678'],
            ['kuphal.estella@hotmail.com', ''],
            ['', ''],
            [' ', ' '],
            ['kuphal.estellahotmail.com', '12345678'],
        ];
    }

    /**
     * Test function authenticate fail when is wrong email
     *
     * @return void
     */
    public function testAuthLoginFailWWrongEmail()
    {
        $response = $this->get('/login');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => 'tungkkhahaa@hotmail.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

     /**
     * Test function authenticate fail when is wrong password
     *
     * @return void
     */
    public function testAuthLoginFailWWrongPassword()
    {
        $response = $this->get('/login');
        Session::start();
        $user = User::first();
        $response = $this->post('login', [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => '123456789jfjf',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
