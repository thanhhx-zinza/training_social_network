<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testListUserSuccess()
    {
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('/admin/users');
        $response->assertOk();
    }

    /**
     * Test function create user success
     *
     * @return void
     */


    /**
     * Test function store user successfully
     *
     * @return void
     */
    public function testStoreUserSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/users', [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test function store user fail in validate
     *
     * @param string $email
     * @param string $password
     *
     * @dataProvider providerTestStoreFailInValidate
     */

    public function testStoreFailInValidate($name, $email, $password)
    {
        $this->get('/admin/users/create');
        Session::start();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/users', [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/users/create");
    }

    /**
     * Provider for function providerTestStoreFailInValidate()
     *
     * @return array
     */

    public function providerTestStoreFailInValidate()
    {
        return [
            ['', '', '12345678'],
            ['', 'kuphal.estella@hotmail.com', ''],
            ['', '', ''],
            [' ', ' ', ' '],
            ['', 'kuphal.estellahotmail.com', '12345678'],
        ];
    }

    /**
     * Test function edit user success
     *
     * @return void
     */

    public function testEditUserSuccess()
    {
        Session::start();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $user = User::first();
        $response = $this->get('/admin/users/'.$user->id.'/edit/');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['user']));
        $response->assertOk();
    }

    /**
     * Test function edit user fails
     *
     * @return void
     */

    public function testEditAdminFail()
    {
        $this->get('/admin/users/');
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $user = User::first();
        $response = $this->get('/admin/users/'.$user->id.'1132/edit/');
        $response->assertStatus(302);
        $response->assertRedirect('/admin/users/');
    }

    // /**
    //  * Test function audate user success
    //  *
    //  * @return void
    //  */

    public function testUpdateUserSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $user = User::first();
        $response = $this->put('/admin/users/'.$user->id, [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/users");
    }

     /**
     * Test function delete user sucess
     *
     * @return void
     */

    public function testDestroySuccess()
    {
        Session::start();
        $this->get('/admin/users');
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $user = User::first();
        $response = $this->delete('/admin/users/'.$user->id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/users");
    }
}
