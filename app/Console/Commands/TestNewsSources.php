<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Source;
use App\Jobs\FetchArticlesJob;
use App\Services\News\NewsApiService;
use App\Services\News\GuardianService;
use App\Services\News\BbcService;

class TestNewsSources extends Command
{
    protected $signature = 'news:test';
    protected $description = 'Test fetching news from all enabled sources';

    public function handle()
    {
        $this->info("🔍 Running test fetch for all enabled news sources...\n");

        $sources = Source::where('enabled', true)->get();

        if ( $sources->isEmpty() ) {
            $this->error("❌ No sources found.");
            return Command::FAILURE;
        }

        foreach ($sources as $source) {
            $this->line("➡ Testing source: {$source->name} ({$source->code})");
            
            try {
                FetchArticlesJob::dispatchSync($source->id);
                $this->info("✅ Success fetching from: {$source->name}\n");

            } catch (\Exception $e) {
                $this->error("❌ Failed fetching from {$source->name}");
                $this->error($e->getMessage());
                $this->line("");
            }
        }

        $this->info("🎉 Test finished.");
        return Command::SUCCESS;
    }
}