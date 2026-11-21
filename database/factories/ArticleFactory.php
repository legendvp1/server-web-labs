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
        $imageSuffix = fake()->randomElement(['', '_2']);

        return [
            'title' => fake()->sentence(4),
            'summary' => fake()->sentence(10),
            'content' => fake()->paragraph(4),
            'preview_image' => "preview{$imageSuffix}.jpg",
            'full_image' => "full{$imageSuffix}.jpeg",
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
