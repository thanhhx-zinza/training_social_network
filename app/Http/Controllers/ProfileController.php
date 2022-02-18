<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileValidate;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $profiles = Auth::User()->profile;
        return view('profile.index', ['profiles' => $profiles]);
    }
    public function edit()
    {
        $profiles = Auth::User()->profile;
        return view('profile.edit', ['profiles' => $profiles]);
    }
    public function update(ProfileValidate $request)
    {
        $profiles = Auth::User()->profile;
        $profileBeforeUpdate = array();
        $profileBeforeUpdate = [
            'first_name' => $profiles->first_name,
            'last_name' => $profiles->last_name,
            'phone_number' => $profiles->phone_number,
            'birthday' => $profiles->birthday,
            'address' => $profiles->address,
            'gender' => $profiles->gender
        ];
        // dd($profiles, $profileBeforeUpdate);
        $profiles->first_name = $request->first_name;
        $profiles->last_name = $request->last_name;
        $profiles->phone_number = $request->phone_number;
        $profiles->birthday = $request->birthday;
        $profiles->address = $request->address;
        $profiles->gender = $request->gender;
        $profiles->save();
        $profileAfterUpdate = [
            'first_name' => $profiles->first_name,
            'last_name' => $profiles->last_name,
            'phone_number' => $profiles->phone_number,
            'birthday' => $profiles->birthday,
            'address' => $profiles->address,
            'gender' => $profiles->gender
        ];
        if ($profileAfterUpdate != $profileBeforeUpdate) {
            return redirect()->route('profile.show');
        } else {
            return back();
        }
    }
}
