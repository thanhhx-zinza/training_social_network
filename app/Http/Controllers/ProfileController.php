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
        return view('profile.index', ['profile' => $profile]);
    }

    public function edit()
    {
        $profile = $this->currentUser()->profile;
        return view('profile.edit', ['profile' => $profile]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('images', $imageName, 'public');
        $profile = $this->currentUser()->profile;
        $profile->avatar = $imageName;
        $profile->save();
        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('profile', $profile);
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
