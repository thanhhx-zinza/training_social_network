<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Comment;
use App\Models\Setting;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class CreateFriendTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetAddFriendListSuccess()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get('/relations');
        $response->assertStatus(200);
    }

    public function testAddFriendSuccess()
    {
        Session::start();
        $faker = Factory::create();
        $data = [
            'name' => $faker->name,
            'password' => 12345678,
            'email' => $faker->email,
        ];
        $userId = User::insertGetId($data);
        $setting = Setting::insert([
            'is_noti' => 1,
            'is_add_friend' => 1,
            "user_id" => $userId,
        ]);
        $user = User::first();
        $this->be($user);
        $response = $this->post("/relations/".$userId, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/relations");
    }

    public function testListRequestAddFriend()
    {
        $user = User::first();
        $this->be($user);
        $response = $this->get("/relations/requests");
        $response->assertStatus(200);
    }

    public function testResponRequestAddFriendSuccess()
    {
        Session::start();
        $response = $this->get("/relations/requests");
        $userId = User::orderBy("id", "desc")->first()->id;
        $user = User::first();
        $this->be($user);
        $response = $this->post("/relations/".$userId, [
            "type" => "Accept",
            '_token' => csrf_token(),
            "_method" => "PATCH",
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/relations/requests");
    }

    public function testResponRequestAddFriendFails()
    {
        Session::start();
        $response = $this->get("/relations/requests");
        $userId = User::orderBy("id", "desc")->first()->id;
        $user = User::first();
        $this->be($user);
        $response = $this->post("/relations/".$userId, [
            "type" => "Nothing",
            '_token' => csrf_token(),
            "_method" => "PATCH",
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/error");
    }
}
