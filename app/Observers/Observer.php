<?php

namespace App\Observers;
use Auth;

class Observer
{
    public function checkSettingNotifi()
    {
        $check = Auth::user()->setting()->get()->toArray();
        if ($check[0]['is_noti'] == 1) {
            return true;
        }
        return false;
    }
}
