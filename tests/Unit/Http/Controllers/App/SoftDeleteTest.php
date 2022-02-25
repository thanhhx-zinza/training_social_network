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
        Session::start();
        $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'name',
            'email' => 'laivanA@gmail.com',
            'password' => '12345678',
        ]);
        $user = User::orderBy('id', 'desc')->first();
        User::onlyTrashed($user->id);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'name',
            'email' => 'laivanA@gmail.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
