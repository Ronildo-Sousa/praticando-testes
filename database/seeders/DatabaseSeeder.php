<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();

        Article::factory()
            ->has(Comment::factory()->for($user)->count(2))
            ->count(3)
            ->for($user)
            ->create();
    }
}
