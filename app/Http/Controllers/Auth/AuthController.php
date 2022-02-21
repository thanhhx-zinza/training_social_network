<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class AuthController extends Controller
{
    /**
     * Show form login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     */
    public function authenticate(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            if (Auth::User()->profile == null) {
                Profile::create([
                    'user_id' => Auth::User()->id,
                    'first_name' => '',
                    'last_name' => '',
                    'phone_number' => '',
                    'gender' => '',
                    'birthday' => '1900-01-01',
                    'address' => ''
                ]);
                // dd(Auth::User()->profile->id);
                return redirect()->route('profile.edit');
            } else {
                // dd(Auth::User()->profile);
                if (Auth::User()->profile->first_name == ''
                || Auth::User()->profile->last_name == ''
                || Auth::User()->profile->phone_number == ''
                || Auth::User()->profile->birthday == ''
                ) {
                    return redirect()->route('profile.edit');
                } else {
                    return view('welcome');
                }
            }
        } else {
            return back()->withInput();
        }
    }

    /**
     * Show form register
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Register an account.
     *
     */
    public function registerAccount(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            Auth::login($user);
            return redirect(route('home.index'));
        } else {
            return back()->withInput();
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
