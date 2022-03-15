<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function auth()
    {
        return auth('api');
    }
    public function currentUser()
    {
        return $this->auth()->user();
    }

    public function responseError($data = [], $statusCode = 400)
    {
        return response()->json($data, $statusCode);
    }

    public function responseSuccess($data = [], $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }

    public function response404()
    {
        return abort(Response::HTTP_NOT_FOUND);
    }
}
