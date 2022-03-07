<?php

namespace App\Console\SendMail;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredUsers as RegisteredMail;
use App\Models\User;

class RegisteredUsers
{
    public function __invoke()
    {
        $users = User::whereDate('created_at', date('Y-m-d'))->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new RegisteredMail());
        }
    }
}
