<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

class DashboardController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('adminAuth');
    }

    public function index()
    {
        return view("admin.dashboard");
    }
}
