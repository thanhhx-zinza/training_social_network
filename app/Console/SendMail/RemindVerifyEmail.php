<?php

namespace App\Console\SendMail;

use App\Models\User;
use Carbon\Carbon;

class RemindVerifyEmail
{
    public function __invoke()
    {
        $users = User::where('created_at', Carbon::now()->subDays(7))
            ->where('email_verified_at', null)
            ->get();
        foreach ($users as $user) {
            $user->sendRemindVerifyEmailNotification();
        }
    }
}
