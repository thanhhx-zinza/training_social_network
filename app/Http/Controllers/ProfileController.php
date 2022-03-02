<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileValidate;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = $this->currentUser()->profile;
        return view('profile.index', ['profiles' => $profile]);
    }
    public function edit()
    {
        $profile = $this->currentUser()->profile;
        return view('profile.edit', ['profiles' => $profile]);
    }
    public function update(ProfileValidate $request)
    {
        $this->currentUser()->profile()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);
        return redirect()->route('profile.show');
    }
}
