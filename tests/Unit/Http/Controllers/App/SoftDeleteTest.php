<?php

namespace Tests\Unit\Http\Controllers\App;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Post;
use Faker\Factory;

class SoftDeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function testSoftDeleteSuccess()
    {
        $response = $this->get('/register');
        Session::start();
        $faker = Factory::create();
        $arr = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->name,
        ];
        $this->post('/register', [
            '_token' => csrf_token(),
            'name' => $arr['name'],
            'email' => $arr['email'],
            'password' => $arr['password'],
        ]);
        $user = User::orderBy('id', 'desc')->first();
        $user->delete();
        $this->assertDatabaseHas('users', ['email' => $arr['email']]);
        $this->assertDatabaseMissing('users', ['email' => $arr['email'], 'deleted_at' => null]);

        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => $arr['name'],
            'email' => $arr['email'],
            'password' => $arr['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => $arr['email'], 'deleted_at' => null]);
    }
}
