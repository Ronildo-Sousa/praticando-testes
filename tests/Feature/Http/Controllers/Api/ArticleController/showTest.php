<?php

namespace Tests\Feature\Http\Controllers\Api\ArticleController;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class showTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function article_id_should_be_exists_on_database()
    {
        $user = User::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
                    ->getJson(route('articles.show', ['article' => 1]));

        $response->assertStatus(404);
    }

    /** @test */
    public function article_should_be_returned()
    {
        $user = User::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;

        $article = Article::factory()->for($user)->create();

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
                    ->getJson(route('articles.show', ['article' => 1]));

        $response->assertStatus(200);
    }
}
