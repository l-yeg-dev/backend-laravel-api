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
            'title' => fake()->text(100),
            'article_id' => fake()->numerify('art-####'),
            'description' => fake()->paragraph(1),
            'url' => fake()->url(),
            'content' => fake()->paragraph(3),
            'image_url' => fake()->imageUrl(640, 480, 'animals', true),
            'source_id' => rand(1,3),
            'category_id' => rand(1,3),
            'author_id' => rand(1,3),
            'published_at' => fake()->datetime()
        ];
    }
}
