<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
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
        $fullImage = fake()->randomElement(array_keys(Article::IMAGES));

        return [
            'title' => fake()->sentence(4),
            'summary' => fake()->sentence(10),
            'content' => fake()->paragraph(4),
            'preview_image' => Article::IMAGES[$fullImage],
            'full_image' => $fullImage,
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
