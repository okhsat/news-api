<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class GuardianService implements NewsSourceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    public function fetchArticles(): array
    {
        $response = Http::get('https://content.guardianapis.com/search', [
            'api-key' => $this->apiKey,
            'show-fields' => 'all',
            'page-size' => 50,
        ]);

        if ( ! $response->successful() ) return [];

        return collect($response->json()['response']['results'])->map(function ($item) {
            // Try to determine category from "sectionName" if available
            $category = $item['sectionName'] ?? 'General';

            return [
                'title'        => $item['webTitle'] ?? null,
                'description'  => $item['fields']['trailText'] ?? null,
                'content'      => $item['fields']['body'] ?? null,
                'author'       => $item['fields']['byline'] ?? null,
                'url'          => $item['webUrl'] ?? null,
                'image_url'    => $item['fields']['thumbnail'] ?? null,
                'published_at' => $item['webPublicationDate'] ?? null,
                'category'     => $category,
            ];
            
        })->toArray();
    }
}