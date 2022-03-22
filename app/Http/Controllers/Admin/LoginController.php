<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials, $request->remember ? true : false)) {
            $request->session()->regenerate();
            Auth::guard('admin')->login(Admin::where('email', $request->email)->first());
            return redirect()->route("dashboard.index");
        }
        return redirect()->back()->withInput($request->only('email'))->with("message", "Login Fails");
    }

    public function show()
    {
        return view("admin.login");
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show');
    }
}
