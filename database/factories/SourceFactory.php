<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    protected $model = Source::class;

    public function definition()
    {
        return [
            'name'     => $this->faker->company . ' News',
            'code'     => $this->faker->unique()->word,
            'api_url'  => $this->faker->optional()->url,
            'logo_url' => $this->faker->optional()->imageUrl(),
            'enabled'  => true,
        ];
    }
}