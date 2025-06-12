<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'published_at' => now()->subDays(rand(1, 14)),
            'views' => rand(0, 100),
            'created_at' => now()->subDays(rand(1, 14)),
            'updated_at' => now(),
        ];
    }

    /**
     * State for recent articles (within 7 days).
     */
    public function recent()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now()->subDays(rand(0, 6)),
                'created_at' => now()->subDays(rand(0, 6)),
            ];
        });
    }
}
