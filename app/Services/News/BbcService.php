<?php

namespace App\Services\News;

use SimpleXMLElement;

class BbcService implements NewsSourceInterface
{
    protected string $rssUrl = 'http://feeds.bbci.co.uk/news/rss.xml';

    public function fetchArticles(): array
    {
        $xml = @simplexml_load_file($this->rssUrl);
        if (!$xml) return [];

        return collect($xml->channel->item)->map(function ($item) {
            return [
                'title'        => (string) $item->title,
                'description'  => (string) $item->description,
                'content'      => null,
                'author'       => null,
                'url'          => (string) $item->link,
                'image_url'    => null,
                'published_at' => (string) $item->pubDate,
            ];
        })->toArray();
    }
}