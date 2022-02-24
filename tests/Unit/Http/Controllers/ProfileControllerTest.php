<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Bill;
use App\Models\Profile;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public $profile;
    public $profile_token;

    protected function setUp() : void
    {
        parent::setup();
        Session::start();
        $faker = Factory::create();
        User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->name(),
        ]);
        $this->profile = [
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'address' => $faker->address,
            'gender' => $faker->randomElement(['male', 'female']),
            'birthday' => $faker->datetime(),
            'phone_number' => $faker->phonenumber,
        ];
        $this->new = profile::create($this->profile);
    }

    /**
     * Test update invalid error
     *
     * @dataProvider provider
     */
    public function testUpdateInvalidError($first_name, $last_name, $address, $gender, $birthday)
    {
        Session::start();
        $this->be(User::orderby('id', 'desc')->first());
        $a = Auth::User()->profile;
        $response = $this->call('POST', '/profile/update', array(
            '_token' => csrf_token(),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address' => $address,
            'gender' => $gender,
            'birthday' => $birthday
        ));
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function provider()
    {
        $faker = Factory::create();
        $profile = [
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'address' => $faker->address,
            'gender' => $faker->randomElement(['male', 'female']),
            'birthday' => $faker->datetime()
        ];
        $profilez = array($profile, $profile, $profile, $profile);
        $profilez[0]['first_name'] = '';
        $profilez[1]['last_name'] = '';
        $profilez[2]['address'] = '';
        $profilez[3]['gender'] = '';
        $result = array();
        $a = array();
        for ($i = 0; $i <= 3; $i++) {
            $a = array();
            foreach ($profilez[$i] as $x => $x_value) {
                array_push($a, $x_value);
            }
            array_push($result, $a);
        }
        return $result;
    }

    public function testUpdateSuccess()
    {
        $this->be(User::orderby('id', 'desc')->first());
        $a = Auth::User()->profile;
        $this->profile = [
            'first_name' => $a->first_name,
            'last_name' => $a->last_name,
            'address' => $a->address,
            'gender' => $a->gender,
            'birthday' => $a->birthday,
            'phone_number' => $a->phone_number,
        ];
        $response = $this->call('POST', '/profile/update', $this->profile);
        $response->assertRedirect('/profile/show');
        $this->assertDatabaseHas('profiles', $this->profile);
    }

    public function testShow()
    {
        $this->be(User::orderby('id', 'desc')->first());
        $response = $this->call('GET', '/profile/show');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEdit()
    {
        $this->be(User::orderby('id', 'desc')->first());
        $response = $this->call('GET', '/profile/edit');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
