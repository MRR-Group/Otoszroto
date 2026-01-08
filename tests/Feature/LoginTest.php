<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPageRenders(): void
    {
        $response = $this->get(route("login"));

        $response->assertOk();

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Auth/Login"),
        );
    }

    public function testUserCanLoginAndIsRedirectedHome(): void
    {
        $user = User::query()->create([
            "name" => "Jan Kowalski",
            "firstname" => "Jan",
            "surname" => "Kowalski",
            "phone" => "123123123",
            "email" => "jan@example.com",
            "password" => "password123",
        ]);

        $payload = [
            "email" => "jan@example.com",
            "password" => "password123",
        ];

        $response = $this->post(route("auth.login.store"), $payload);

        $response->assertRedirect(route("home"));
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginFailsWithInvalidCredentials(): void
    {
        User::query()->create([
            "name" => "Jan Kowalski",
            "firstname" => "Jan",
            "surname" => "Kowalski",
            "phone" => "123123123",
            "email" => "jan@example.com",
            "password" => "password123",
        ]);

        $payload = [
            "email" => "jan@example.com",
            "password" => "wrong-password",
        ];

        $response = $this->postJson(route("auth.login.store"), $payload);

        $response->assertStatus(403);
        $response->assertJsonValidationErrors(["message"]);
    }

    public function testLoginIsRateLimitedAfterTooManyAttempts(): void
    {
        $email = "jan@example.com";
        $ip = "10.10.10.10";
        $key = "login:" . strtolower($email) . "|" . $ip;

        RateLimiter::clear($key);

        for ($i = 0; $i < 5; $i++) {
            RateLimiter::hit($key);
        }

        $payload = [
            "email" => $email,
            "password" => "any",
        ];

        $response = $this->withServerVariables(["REMOTE_ADDR" => $ip])
            ->postJson(route("auth.login.store"), $payload);

        $response->assertStatus(429);
        $response->assertJsonValidationErrors(["message"]);
    }
}
