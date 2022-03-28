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
use Hash;

class AdminTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $faker = Factory::create();
        Admin::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => Hash::make(12345678),
        ]);
    }

    public function testListAdminSuccess()
    {
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('admin/admins');
        $response->assertOk();
    }

    /**
     * Test function create admin success
     *
     * @return void
     */

    public function testCreateAdminSuccess()
    {
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('admin/admins/create');
        $response->assertViewIs('admin.list-admin.create-update');
        $response->assertOk();
    }

    /**
     * Test function store admin successfully
     *
     * @return void
     */
    public function testStoreAdminSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/admins', [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/");
    }

    /**
     * Test function store admin fail in validate
     *
     * @param string $email
     * @param string $password
     *
     * @dataProvider providerTestStoreFailInValidate
     */

    public function testStoreFailInValidate($name, $email, $password)
    {
        $this->get('/admin/admins/create');
        Session::start();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/admins', [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/admins/create");
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
     * Test function edit admin success
     *
     * @return void
     */

    public function testEditAdminSuccess()
    {
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('/admin/admins/'.$admin->id.'/edit/');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['admin']));
        $response->assertOk();
    }

   
    /**
     * Test function audate admin success
     *
     * @return void
     */

    public function testUpdateAdminSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
        $response = $this->put('/admin/admins/'.$admin->id, [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/admins");
    }

     /**
     * Test function delete admin sucess
     *
     * @return void
     */

    public function testDestroySuccess()
    {
        Session::start();
        $this->get('/admin/admins');
        $admin = Admin::first();
        $otherAdmin = Admin::orderBy("id", "desc")->first();
        Auth::guard("admin")->login($admin);
        $response = $this->delete('/admin/admins/'.$otherAdmin->id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/admins");
    }
}
