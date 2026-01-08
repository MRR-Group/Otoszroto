<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordPageRenders(): void
    {
        $response = $this->get(route("auth.resetPassword.create"));

        $response->assertOk();

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Auth/ResetPassword"),
        );
    }

    public function testPasswordIsResetSuccessfully(): void
    {
        $this->mock(ResetPasswordAction::class, function ($mock): void {
            $mock->shouldReceive("execute")
                ->once()
                ->andReturn(true);
        });

        $payload = [
            "token" => "valid-token",
            "email" => "jan@example.com",
            "password" => "password123",
            "password_confirmation" => "password123",
        ];

        $response = $this->post(route("auth.resetPassword.store"), $payload);

        $response->assertRedirect(route("login"));
        $response->assertSessionHas("message", "Your password has been reset.");
    }

    public function testPasswordResetFailsWithInvalidToken(): void
    {
        $this->mock(ResetPasswordAction::class, function ($mock): void {
            $mock->shouldReceive("execute")
                ->once()
                ->andReturn(false);
        });

        $payload = [
            "token" => "invalid-token",
            "email" => "jan@example.com",
            "password" => "password123",
            "password_confirmation" => "password123",
        ];

        $response = $this->from(route("auth.resetPassword.create"))
            ->post(route("auth.resetPassword.store"), $payload);

        $response->assertRedirect(route("auth.resetPassword.create"));
        $response->assertSessionHas("message", "Reset token has expired or is invalid.");
        $response->assertSessionHasInput(["email"]);
    }
}
