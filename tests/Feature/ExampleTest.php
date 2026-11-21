<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_home_page_displays_articles_from_the_database(): void
    {
        $article = Article::factory()->create([
            'title' => 'Пример статьи из базы',
            'preview_image' => 'preview.jpg',
            'full_image' => 'full.jpeg',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeText($article->title)
            ->assertSeeText($article->summary)
            ->assertSeeText($article->content)
            ->assertSee('src="/preview.jpg"', false)
            ->assertSee(route('galery', ['full_image' => 'full.jpeg']));
    }
}
