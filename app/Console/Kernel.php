<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\SendMail\RegisteredUsers;
use App\Console\SendMail\RemindVerifyEmail;
use App\Console\SendMail\RemindPost;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Ho_Chi_Minh';
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(new RegisteredUsers)->dailyAt('18:00')->name('registered_user')->withoutOverlapping();
        $schedule->call(new RemindVerifyEmail)->daily()->name('remind_verify_email')->withoutOverlapping();
        $schedule->call(new RemindPost)->daily()->name('remind_post')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
