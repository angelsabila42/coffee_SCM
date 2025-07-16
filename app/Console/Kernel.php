<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Update incoming orders daily at 1:00 AM
        $schedule->command('orders:update-incoming')
            ->dailyAt('01:00')
            ->withoutOverlapping()
            ->onFailure(fn () => Log::error('Incoming order update failed at ' . now()))
            ->onSuccess(fn () => Log::info('Incoming order update completed at ' . now()));

        // Update outgoing orders daily at 2:00 AM
        $schedule->command('orders:update-outgoing')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->onFailure(fn () => Log::error('Outgoing order update failed at ' . now()))
            ->onSuccess(fn () => Log::info('Outgoing order update completed at ' . now()));

        // Weekly report every Monday at 3:00 AM
        $schedule->command('report:weekly')
            ->weeklyOn(1, '03:00')
            ->withoutOverlapping();

        // Monthly report on the 1st at 9:00 AM
        $schedule->command('report:monthly')
            ->monthlyOn(1, '09:00')
            ->withoutOverlapping();

        // Yearly report on Jan 1st at 10:00 AM
        $schedule->command('report:yearly')
            ->yearlyOn(1, 1, '10:00')
            ->withoutOverlapping();

        // Trigger ML model daily at 3:00 AM
        $schedule->command('ml:process-data')
            ->dailyAt('03:00')
            ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
