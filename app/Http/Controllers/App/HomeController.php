<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display view home
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('app.home');
    }
}
