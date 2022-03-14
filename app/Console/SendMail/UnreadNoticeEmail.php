<?php
namespace App\Console\SendMail;

use App\Mail\UnreadNoticeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UnreadNoticeEmail
{
    public function __invoke()
    {
        $users = User::getNoticesUnRead();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new UnreadNoticeMail($user->notifications));
        }
    }
}
