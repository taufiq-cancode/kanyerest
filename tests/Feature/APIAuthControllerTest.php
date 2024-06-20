<?php 

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class APIAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_registers_a_new_user_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function it_fails_registration_due_to_validation_errors()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'not_matching',
        ]);

        $response->assertStatus(422);

        $response->assertJsonFragment(['email' => ['The email must be a valid email address.']]);
        $response->assertJsonFragment([
            'password' => [
                'The password must be at least 8 characters.',
                'The password confirmation does not match.',
            ]
        ]);
    }

    /** @test */
    public function it_logs_in_a_user_successfully()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
    }

    /** @test */
    public function it_fails_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid login details']);
    }
}
