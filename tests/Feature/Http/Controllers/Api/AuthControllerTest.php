<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_should_be_stored_in_database()
    {
        $response = $this->post(route('auth.register'), [
            'name' => "user test",
            "email" => "user@test.com",
            "password" => "123"
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function register_fields_should_be_required()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => "",
            "email" => "",
            "password" => ""
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(["message" =>  "The given data was invalid."]);
    }


    /** @test */
    public function user_shold_be_able_to_login_in_to_account()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), ["email" => $user->email, "password" => "password"]);

        $response->assertStatus(200)
                ->assertJsonFragment(["message" => "User logged in successfully."]);
    }

    /** @test */
    public function login_fields_should_be_required()
    {
        $response = $this->postJson(route('auth.login'), [
            "email" => "",
            "password" => ""
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(["message" =>  "The given data was invalid."]);
    }

    // /** @test */
    // public function user_shold_be_able_to_logout_of_account()
    // {
    //     $this->withoutExceptionHandling();
    // }
}
