<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Mockery;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_page_renders(): void
    {
        $response = $this->get(route('auth.resetPassword.create'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auth/ResetPassword')
        );
    }

    public function test_password_is_reset_successfully(): void
    {
        $this->mock(ResetPasswordAction::class, function ($mock): void {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn(true);
        });

        $payload = [
            'token' => 'valid-token',
            'email' => 'jan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('auth.resetPassword.store'), $payload);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('message', 'Your password has been reset.');
    }

    public function test_password_reset_fails_with_invalid_token(): void
    {
        $this->mock(ResetPasswordAction::class, function ($mock): void {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn(false);
        });

        $payload = [
            'token' => 'invalid-token',
            'email' => 'jan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->from(route('auth.resetPassword.create'))
            ->post(route('auth.resetPassword.store'), $payload);

        $response->assertRedirect(route('auth.resetPassword.create'));
        $response->assertSessionHas('message', 'Reset token has expired or is invalid.');
        $response->assertSessionHasInput(['email']);
    }
}
