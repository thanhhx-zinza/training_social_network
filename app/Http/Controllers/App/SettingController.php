<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = $this->currentUser()->setting;
        return view('app.setting', ['setting' => $setting]);
    }

    /**
     * Change setting
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeSettings(Request $request)
    {
        $isNoti = ($request->isNoti && $request->isNoti === 'on') ? 1 : 0;
        $isAddFriend = ($request->isAddFriend && $request->isAddFriend === 'on') ? 1 : 0;
        $this->currentUser()->setting()->update([
            'is_noti' => $isNoti,
            'is_add_friend' => $isAddFriend,
        ]);
        return redirect('/settings');
    }
}
