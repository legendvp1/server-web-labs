<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testUser = [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ];

        User::firstOrCreate(
            ['email' => $testUser['email']],
            fn () => User::factory()->raw($testUser),
        );

        $articlesToCreate = max(0, 10 - Article::count());
        Article::factory()->count($articlesToCreate)->create();
    }
}
