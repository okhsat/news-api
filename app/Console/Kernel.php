<?php

namespace App\Console;

use App\Jobs\FetchArticlesJob;
use App\Models\Source;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\TestNewsSources::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $sources = Source::where('enabled', true)->get();

            if ( $sources->isEmpty() ) return;

            foreach ($sources as $source) {
                FetchArticlesJob::dispatch($source->id);
            }

        })->everyFifteenMinutes();
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