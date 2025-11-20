<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class NewsApiService implements NewsSourceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key'); // store key in .env
    }

    public function fetchArticles(): array
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => $this->apiKey,
            'language' => 'en',
            'pageSize' => 50,
        ]);

        if (!$response->successful()) {
            return [];
        }

        // Normalize articles
        return collect($response->json()['articles'])->map(function ($item) {
            return [
                'title'        => $item['title'] ?? null,
                'description'  => $item['description'] ?? null,
                'content'      => $item['content'] ?? null,
                'author'       => $item['author'] ?? null,
                'url'          => $item['url'] ?? null,
                'image_url'    => $item['urlToImage'] ?? null,
                'published_at' => $item['publishedAt'] ?? null,
            ];
        })->toArray();
    }
}