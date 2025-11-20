<?php

namespace App\Console;

use App\Jobs\FetchArticlesJob;
use App\Models\Source;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $sources = Source::all();

            foreach ($sources as $source) {
                switch ($source->code) {
                    case 'newsapi':
                        $service = new \App\Services\News\NewsApiService();
                        break;
                    case 'guardian':
                        $service = new \App\Services\News\GuardianService();
                        break;
                    case 'bbc':
                        $service = new \App\Services\News\BbcService();
                        break;
                    default:
                        continue 2;
                }

                FetchArticlesJob::dispatch($source, $service);
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