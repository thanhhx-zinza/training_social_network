<?php

namespace App\Console\SendMail;

use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemindPost as Remind;

class RemindPost
{
    public function __invoke()
    {
        $posts = Post::distinct()->select('user_id')->get();
        $users = User::where('created_at', Carbon::now()->subDays(30))
            ->whereNotIn('id', $posts)
            ->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new Remind);
        }
    }
}
