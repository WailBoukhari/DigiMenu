<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Find users whose subscriptions have expired
            $expiredUsers = User::where('subscription_expires_at', '<=', now())->get();

            // Delete expired users and their associated data
            foreach ($expiredUsers as $user) {
                $user->delete();
                $user->menus()->delete(); // Delete associated menus

            }
        })->everySecond(); // Run the task every minute
    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
