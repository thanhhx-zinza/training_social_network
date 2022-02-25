<?php

namespace Tests\Unit\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

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
        $response = $this->get('/login');
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
        $user = User::orderBy('id', 'desc')->first();
<<<<<<< HEAD
        $faker = Factory::create();
        $profile = [
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'address' => $faker->address,
            'gender' => $faker->randomElement(['male', 'female']),
            'birthday' => $faker->datetime(),
            'phone_number' => '0982048209',
        ];
        $new = profile::create($profile);
=======
>>>>>>> Fix register
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/");
    }

<<<<<<< HEAD
    /**
     * Test login without profile
     *
     * @dataProvider provider
     */
    public function testLoginWithoutProfile($first_name, $last_name, $phone_number, $birthday)
=======
    public function testLoginWithoutProfile()
>>>>>>> Fix register
    {
        Session::start();
        $user = User::orderBy('id', 'desc')->first();
<<<<<<< HEAD
        $profile = [
            'user_id' => User::orderBy('id', 'desc')->first()->id,
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'address' => $faker->address,
            'phone_number' => $faker->phonenumber,
            'gender' => $faker->randomElement(['male', 'female']),
            'birthday' => $faker->datetime()
        ];
        $new = profile::create($profile);
        $profile = $user->profile;
        $profile->first_name = $first_name;
        $profile->last_name = $last_name;
        $profile->phone_number = $phone_number;
        $profile->birthday = $birthday;
        $profile->save();
=======
        $this->be($user);
>>>>>>> Fix register
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => "abc98@gmail.com",
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
<<<<<<< HEAD
        $response->assertRedirect('/profile/edit');
    }

    public function provider()
    {
        $faker = Factory::create();
        $profile = [
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'phone_number' => $faker->phonenumber,
            'birthday' => $faker->datetime()
        ];
        $profilez = array($profile, $profile, $profile);
        $profilez[0]['first_name'] = '';
        $profilez[1]['last_name'] = '';
        $profilez[2]['phone_number'] = '';
        $result = array();
        $a = array();
        for ($i = 0; $i <= 2; $i++) {
            $a = array();
            foreach ($profilez[$i] as $x => $x_value) {
                array_push($a, $x_value);
            }
            array_push($result, $a);
        }
        return $result;
=======
       // $response->assertRedirect('/profile/edit');
>>>>>>> Fix register
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
        $response = $this->get('/login');
        Session::start();
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
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
            'email' => 'tungkkhahaa@hotmail.com',
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
        $user = User::first();
        $response = $this->post('login', [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => '123456789jfjf',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testRegisterAccountSuccess()
    {
        Session::start();
        $response = $this->post('register', [
            '_token' => csrf_token(),
            'email' => "abcd@gmail.com",
            "name" =>  "Teo",
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testRegisterFormSuccess()
    {
        Session::start();
        $response = $this->get('register');
        $response->assertStatus(200);
    }
}
