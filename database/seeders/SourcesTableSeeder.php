<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Source;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'NewsAPI',
                'code' => 'newsapi',
                'api_url' => 'https://newsapi.org/v2/top-headlines',
                'enabled' => true,
            ],
            [
                'name' => 'The Guardian',
                'code' => 'guardian',
                'api_url' => 'https://content.guardianapis.com',
                'enabled' => true,
            ],
            [
                'name' => 'BBC News',
                'code' => 'bbc',
                'api_url' => 'http://feeds.bbci.co.uk/news/rss.xml',
                'enabled' => true,
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(['code' => $source['code']], $source);
        }
    }
}