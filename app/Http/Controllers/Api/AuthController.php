<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Models\Profile;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $token = $this->auth()->attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$token) {
            return $this->responseError(['message' => 'Unauthorized'], 401);
        }
        if ($this->currentUser()->profile == null) {
            Profile::create([
                'user_id' => $this->currentUser()->id,
                'first_name' => '',
                'last_name' => '',
                'phone_number' => '',
                'gender' => '',
                'birthday' => '1900-01-01',
                'address' => ''
            ]);
        }
        return $this->responseSuccess([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 60
        ]);
    }
}
