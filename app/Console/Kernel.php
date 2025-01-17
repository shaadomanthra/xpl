<?php

namespace PacketPrep\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CodeExecute::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('code:execute')->everyMinute();
       $schedule->command('docker:stop')->everyFiveMinutes();
       $schedule->command('docker:remove')->daily();
       //$schedule->command('backup:clean')->daily()->at('09:00');
       //$schedule->command('backup:run')->daily()->at('10:00');
       //$schedule->command('backup:monitor')->daily()->at('11:00');
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
