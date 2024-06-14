<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use MakesGraphQLRequests;
    use RefreshDatabase;

    /**
     * Test user registration.
     */
    public function testUserCanRegister()
    {
        $response = $this->graphQL('
            mutation {
                register(
                    name: "Test User",
                    email: "test@example.com",
                    password: "password",
                    password_confirmation: "password"
                ) {
                    token
                    user {
                        id
                        name
                        email
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'register' => [
                    'user' => [
                        'name' => 'Test User',
                        'email' => 'test@example.com',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Act
        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    login(email: "test@example.com", password: "password123") {
                        token
                        user {
                            id
                            email
                        }
                    }
                }
            ',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'login' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => 'test@example.com',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function user_can_logout_successfully()
    {
        // Arrange
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;
        Auth::guard('sanctum')->setUser($user);

        // Act
        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    logout {
                        message
                        success
                    }
                }
            ',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'logout' => [
                    'message' => 'You have been successfully logged out.',
                    'success' => true,
                ],
            ],
        ]);
    }

}
