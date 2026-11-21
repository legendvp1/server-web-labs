<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_articles_are_split_into_pages(): void
    {
        $oldest = Article::factory()->create([
            'title' => 'Архивная статья',
            'created_at' => now()->subYears(2),
        ]);
        Article::factory()->count(5)->create();

        $this->get(route('articles.index'))
            ->assertOk()
            ->assertSeeText('Страница 1 из 2')
            ->assertDontSeeText($oldest->title);

        $this->get(route('articles.index', ['page' => 2]))
            ->assertOk()
            ->assertSeeText('Страница 2 из 2')
            ->assertSeeText($oldest->title);
    }

    public function test_an_article_can_be_created_viewed_edited_and_deleted(): void
    {
        $this->actingAs(User::factory()->create(), 'web');

        $data = [
            'title' => 'Новая статья для проверки',
            'summary' => 'Краткое описание для проверки',
            'content' => 'Полный текст для проверки',
            'full_image' => 'full_2.jpeg',
        ];

        $this->get(route('articles.create'))->assertOk();
        $response = $this->post(route('articles.store'), $data);
        $article = Article::sole();
        $response->assertRedirect(route('articles.show', $article));
        $this->assertDatabaseHas('articles', $data + ['preview_image' => 'preview_2.jpg']);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSeeText($data['title'])
            ->assertSeeText($data['content']);
        $this->get(route('articles.edit', $article))->assertOk()->assertSee($data['title']);

        $data['title'] = 'Обновлённая статья для проверки';
        $data['full_image'] = 'full.jpeg';
        $this->put(route('articles.update', $article), $data)
            ->assertRedirect(route('articles.show', $article));
        $this->assertDatabaseHas('articles', $data + ['id' => $article->id, 'preview_image' => 'preview.jpg']);

        $this->delete(route('articles.destroy', $article))->assertRedirect(route('articles.index'));
        $this->assertModelMissing($article);
        $this->get(route('articles.show', $article))->assertNotFound();
    }

    public function test_creation_and_editing_reject_invalid_data(): void
    {
        $this->actingAs(User::factory()->create(), 'web');

        $invalid = ['title' => '', 'summary' => '', 'content' => '', 'full_image' => 'other.jpeg'];
        $fields = array_keys($invalid);

        $this->from(route('articles.create'))
            ->post(route('articles.store'), $invalid)
            ->assertRedirect(route('articles.create'))
            ->assertSessionHasErrors($fields);
        $this->assertDatabaseCount('articles', 0);

        $article = Article::factory()->create();
        $this->from(route('articles.edit', $article))
            ->put(route('articles.update', $article), $invalid)
            ->assertRedirect(route('articles.edit', $article))
            ->assertSessionHasErrors($fields);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'full_image' => $article->full_image,
        ]);
    }
}
