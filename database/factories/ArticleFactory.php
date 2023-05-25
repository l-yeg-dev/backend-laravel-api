<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'articleId' => fake()->numerify('art-####'),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'authors' => fake()->word(),
            'source' => fake()->word(),
            'imageUrl' => fake()->imageUrl(640, 480, 'animals', true),
        ];
    }
}
