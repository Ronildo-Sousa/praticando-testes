<?php

namespace Tests\Feature\Http\Controllers\Api\ArticleController;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class indexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_auth_users_can_see_the_articles()
    {
        $response = $this->getJson(route('articles.index'));

        $response->assertStatus(401);
    }

    /** @test */
    public function should_be_returned_a_list_of_articles()
    {
        $user = User::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;

        $articles = Article::all();

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
                        ->getJson(route('articles.index'));


        $response->assertStatus(200);
        $response->assertJsonFragment(['articles' => $articles->toArray()]);
    }
}
