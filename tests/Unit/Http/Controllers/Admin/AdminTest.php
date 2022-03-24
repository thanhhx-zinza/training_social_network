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
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('/admin/list-admin/index');
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
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->get('/admin/list-admin/create');
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
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/list-admin/store', [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/list-admin/index");
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
        $this->get('/admin/list-admin/create');
        Session::start();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $response = $this->post('/admin/list-admin/store', [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/list-admin/create");
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
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $subAdmin = Admin::where("level", 1)->first();
        $response = $this->get('/admin/list-admin/edit/'.$subAdmin->id);
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['admin']));
        $response->assertOk();
    }

    /**
     * Test function edit admin fails
     *
     * @return void
     */

    public function testEditAdminFail()
    {
        $this->get('/admin/list-admin/index/');
        Session::start();
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $subAdmin = Admin::where("level", 1)->first();
        $response = $this->get('/admin/list-admin/edit/'.$subAdmin->id."1274");
        $response->assertStatus(302);
        $response->assertRedirect('/admin/list-admin/index/');
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
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $subAdmin = Admin::where("level", 1)->first();
        $response = $this->put('/admin/list-admin/update/'.$subAdmin->id, [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/list-admin/index");
    }

     /**
     * Test function delete admin sucess
     *
     * @return void
     */

    public function testDestroySuccess()
    {
        Session::start();
        $this->get('/admin/list-admin/index/');
        $admin = Admin::where('level', 0)->first();
        Auth::guard("admin")->login($admin);
        $subAdmin = Admin::where("level", 1)->first();
        $response = $this->delete('/admin/list-admin/delete/'.$subAdmin->id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/admin/list-admin/index");
    }
}
