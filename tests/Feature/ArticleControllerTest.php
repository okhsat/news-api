<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use App\Models\User;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate using Sanctum
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }

    #[Test]
    public function it_returns_paginated_articles()
    {
        Article::factory()->count(30)->create();

        $response = $this->getJson('/api/articles?per_page=10');

        $response->assertStatus(200)
                 ->assertJsonPath('per_page', 10)
                 ->assertJsonCount(10, 'data');
    }

    #[Test]
    public function it_filters_articles_by_source()
    {
        $sourceA = Source::factory()->create();
        $sourceB = Source::factory()->create();

        Article::factory()->count(5)->create(['source_id' => $sourceA->id]);
        Article::factory()->count(3)->create(['source_id' => $sourceB->id]);

        $response = $this->getJson('/api/articles?source_id=' . $sourceA->id);

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    #[Test]
    public function it_filters_by_category()
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();

        Article::factory()->count(4)->create(['category_id' => $categoryA->id]);
        Article::factory()->count(6)->create(['category_id' => $categoryB->id]);

        $response = $this->getJson('/api/articles?category_id='.$categoryA->id);

        $response->assertStatus(200)
                 ->assertJsonCount(4, 'data');
    }

    #[Test]
    public function it_filters_by_author()
    {
        Article::factory()->create(['author' => 'John Smith']);
        Article::factory()->create(['author' => 'Alice Doe']);

        $response = $this->getJson('/api/articles?author=John');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    #[Test]
    public function it_searches_by_title_and_description()
    {
        Article::factory()->create(['title' => 'Breaking News: Cats Rule']);
        Article::factory()->create(['description' => 'Dogs are cool']);
        Article::factory()->create(['title' => 'Nothing related']);

        $response = $this->getJson('/api/articles?search=cats');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    #[Test]
    public function it_sorts_by_published_date_desc()
    {
        Article::factory()->create(['published_at' => now()->subDays(5)]);
        Article::factory()->create(['published_at' => now()]);

        $response = $this->getJson('/api/articles');

        $this->assertTrue(
            $response->json('data')[0]['published_at']
            >
            $response->json('data')[1]['published_at']
        );
    }

    #[Test]
    public function it_creates_an_article()
    {
        $source = Source::factory()->create();

        $payload = [
            'source_id' => $source->id,
            'title' => 'Test Title',
            'url' => 'https://example.com/article',
        ];

        $response = $this->postJson('/api/articles', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('title', 'Test Title');

        $this->assertDatabaseHas('articles', $payload);
    }

    #[Test]
    public function it_updates_an_article()
    {
        $article = Article::factory()->create();

        $payload = [
            'title' => 'Updated Title',
        ];

        $response = $this->putJson('/api/articles/'.$article->id, $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('title', 'Updated Title');

        $this->assertDatabaseHas('articles', ['id' => $article->id, 'title' => 'Updated Title']);
    }

    #[Test]
    public function it_deletes_an_article()
    {
        $article = Article::factory()->create();

        $response = $this->deleteJson('/api/articles/'.$article->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}