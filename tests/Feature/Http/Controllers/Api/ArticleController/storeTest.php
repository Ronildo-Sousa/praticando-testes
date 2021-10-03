<?php

namespace Tests\Feature\Http\Controllers\Api\ArticleController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class storeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_be_stored_only_with_the_required_fields()
    {
        $user = User::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;

        $article = [
            "title" => "",
            "content" => "",
            "published_at" => ""
        ];

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
                        ->postJson(route('articles.store'), $article);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('articles', $article);
    }

    /** @test */
    public function should_be_stored_in_database()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;

        $article = [
            "title" => "some title",
            "content" => "some content article",
            "published_at" => now()->addHour()
        ];

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
                        ->postJson(route('articles.store'), $article);

        $response->assertStatus(201);
        $response->assertJsonFragment($article);
        $this->assertDatabaseCount('articles', 1);
    }
}
