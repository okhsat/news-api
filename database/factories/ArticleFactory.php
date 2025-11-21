<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'source_id'    => Source::factory(),
            'category_id'  => Category::factory(),
            'title'        => $this->faker->sentence,
            'description'  => $this->faker->paragraph,
            'content'      => $this->faker->text(800),
            'author'       => $this->faker->name,
            'url'          => $this->faker->unique()->url,
            'image_url'    => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTimeBetween('-7 days'),
        ];
    }
}