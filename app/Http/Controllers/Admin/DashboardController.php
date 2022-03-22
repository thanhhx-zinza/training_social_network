<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class DashboardController extends AdminController
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
