<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_saves_the_user_and_redirects_to_login(): void
    {
        $data = [
            'name' => 'Анна',
            'email' => 'anna@example.test',
            'password' => 'example-password',
        ];

        $this->get(route('signin'))->assertOk();
        $this->post(route('signin.registration'), $data)->assertRedirect(route('login'));
        $this->assertGuest('web');

        $user = User::where('email', $data['email'])->sole();
        $this->assertSame($data['name'], $user->name);
        $this->assertTrue(Hash::check($data['password'], $user->password));
        $this->assertNotSame($data['password'], $user->password);
    }

    public function test_registration_rejects_a_duplicate_email_and_an_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->from(route('signin'))->post(route('signin.registration'), [
            'name' => 'Анна',
            'email' => $user->email,
            'password' => str_repeat('я', 37),
        ])->assertRedirect(route('signin'))->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_login_creates_a_sanctum_token_and_logout_revokes_it(): void
    {
        $user = User::factory()->create(['password' => 'example-password']);
        $otherToken = $user->createToken('other-session')->accessToken;

        $this->get(route('login'))->assertOk();
        $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'example-password',
        ])->assertRedirect(route('articles.index'));
        $this->assertAuthenticatedAs($user, 'web');

        $token = $user->tokens()->where('name', 'web-session')->sole();
        $this->assertSame($token->id, session('sanctum_token_id'));
        $csrf = session()->token();
        $this->get(route('articles.create'))->assertOk();

        $this->post(route('logout'))
            ->assertRedirect(route('articles.index'))
            ->assertSessionMissing('sanctum_token_id')
            ->assertSessionHas('_token', fn ($token) => is_string($token) && $token !== $csrf);

        $this->assertGuest('web');
        $this->assertModelMissing($token);
        $this->assertModelExists($otherToken);

        Auth::forgetGuards();
        $this->get(route('articles.create'))->assertRedirect(route('login'));
    }

    public function test_an_incorrect_password_does_not_create_a_token(): void
    {
        $user = User::factory()->create(['password' => 'example-password']);

        $this->from(route('login'))->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect(route('login'))->assertSessionHasErrors('email');

        $this->assertGuest('web');
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_guests_can_read_articles_but_cannot_manage_them(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.index'))->assertOk()->assertDontSeeText('Добавить статью');
        $this->get(route('articles.show', $article))->assertOk()->assertDontSeeText('Редактировать');
        $this->get(route('articles.create'))->assertRedirect(route('login'));
        $this->get(route('articles.edit', $article))->assertRedirect(route('login'));
        $this->post(route('articles.store'))->assertRedirect(route('login'));
        $this->put(route('articles.update', $article))->assertRedirect(route('login'));
        $this->delete(route('articles.destroy', $article))->assertRedirect(route('login'));
        $this->assertModelExists($article);
    }
}
