<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $admin = Admin::first();
        Auth::guard("admin")->login($admin);
    }
    /**
     * Test function index list post for user
     */
    public function testIndexSuccess()
    {
        $user = User::first();
        $response = $this->get("admin/users/".$user->id.'/posts');
        $response->assertViewIs('admin.posts.list-post');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['posts']) && isset($data['user']) && isset($data['paginationNum']));
    }

    /**
     * Test function edit post
     */

    public function testEditSuccess()
    {
        $user = User::orderBy("id", "DESC")->first();
        $post = Post::where('user_id', $user->id)->first();
        $response = $this->get("admin/users/".$user->id."/posts/".$post->id."/edit");
        $response->assertOk();
        $response->assertViewIs('admin.posts.edit');
        $data = $response->getOriginalContent()->getData();
        $this->assertTrue(isset($data['post']) && isset($data['user']) && isset($data['audiences']));
    }

    /**
     * Test function uodate sucess
     */
    public function testUpdateSuccess()
    {
        Session::start();
        $user = User::orderBy("id", "DESC")->first();
        $this->get('/admin/users/'.$user->id.'/posts');
        $faker = Factory::create();
        $post = Post::where('user_id', $user->id)->first();
        $response = $this->put("admin/users/".$user->id."/posts/".$post->id, [
            "content" => $faker->realText(),
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/users/'.$user->id.'/posts');
    }


    /**
     * Test function destroy success
     */
    public function testDestroySuccess()
    {
        Session::start();
        $user = User::orderBy("id", "DESC")->first();
        $this->get('/admin/users/'.$user->id.'/posts');
        $post = Post::where('user_id', '=', $user->id)->first();
        $response = $this->delete("admin/users/".$user->id."/posts/".$post->id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/users/'.$user->id.'/posts');
    }
}
