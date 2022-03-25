<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class BaseAdminController extends BaseController
{
    public function currentAdmin()
    {
        return Auth::guard("admin")->user();
    }
}
