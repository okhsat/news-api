<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Source;
use App\Models\SyncLog;
use App\Services\News\NewsSourceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected NewsSourceInterface $service;
    protected Source $source;

    public function __construct(Source $source, NewsSourceInterface $service)
    {
        $this->source = $source;
        $this->service = $service;
    }

    public function handle(): void
    {
        $articles = $this->service->fetchArticles();

        $fetchedCount = 0;

        foreach ($articles as $data) {
            $data['source_id'] = $this->source->id;

            // Prevent duplicates by URL
            $article = Article::updateOrCreate(
                ['url' => $data['url']],
                $data
            );

            $fetchedCount++;
        }

        // Log the sync
        SyncLog::create([
            'source_id' => $this->source->id,
            'synced_at' => now(),
            'fetched_count' => $fetchedCount,
            'status' => 'success',
        ]);
    }
}