<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileValidate;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $profile = $this->currentUser()->profile;
        return response()->json($profile, 200);
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
        $profile = $this->currentUser()->profile;
        if ($request->hasFile('avatar')
            && $profile->avatar
            && Storage::disk('public')->exists('images/'.$profile->avatar)
        ) {
            Storage::disk('public')->delete('images/'.$profile->avatar);
        }
        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->storeAs('images', $imageName, 'public');
        } else {
            $imageName = $profile->avatar;
        }
        $this->currentUser()->profile()->update([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'phone_number' => $request->phone,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'gender' => $request->gender,
            'avatar' => $imageName,
        ]);
        return response()->json(['message' => 'Update successfully'], 200);
    }
}
