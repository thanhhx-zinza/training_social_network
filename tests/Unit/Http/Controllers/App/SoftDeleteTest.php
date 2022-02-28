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
        $this->post('/register', [
            '_token' => csrf_token(),
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->name,
        ]);
        $user = User::orderBy('id', 'desc')->first();
        $user->delete();
        $newUser = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'password' => $newUser['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', $newUser);
    }
}
