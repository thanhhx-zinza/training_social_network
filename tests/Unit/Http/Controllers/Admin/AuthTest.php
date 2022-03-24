<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Models\Admin;
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
        $response = $this->get('admin/login');
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
        $admin = Admin::first();
        $response = $this->post('admin/login', [
            '_token' => csrf_token(),
            'email' => $admin->email,
            'password' => 12345678,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("admin/dashboard");
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
        $response = $this->get('admin/login');
        Session::start();
        $response = $this->post('admin/login', [
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('admin/login');
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
            'email' => 'abc@hotmail.com',
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
        $admin = Admin::first();
        $response = $this->post('login', [
            '_token' => csrf_token(),
            'email' => $admin->email,
            'password' => '123456789jfjf',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
