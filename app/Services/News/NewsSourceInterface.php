<?php

namespace App\Services\News;

interface NewsSourceInterface
{
    /**
     * Fetch latest articles from the external source.
     *
     * @return array
     */
    public function fetchArticles(): array;
}