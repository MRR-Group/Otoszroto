<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resets_password_and_returns_true_on_success(): void
    {
        Event::fake();

        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'oldpassword123',
        ]);

        Password::shouldReceive('reset')
            ->once()
            ->andReturnUsing(function ($credentials, $callback) use ($user) {
                $callback($user, $credentials['password']);
                return Password::PASSWORD_RESET;
            });

        $action = new ResetPasswordAction();

        $result = $action->execute([
            'email' => 'jan@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'token' => 'valid-token',
        ]);

        $this->assertTrue($result);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        Event::assertDispatched(PasswordReset::class);
    }

    public function test_it_returns_false_when_password_reset_fails(): void
    {
        Password::shouldReceive('reset')
            ->once()
            ->andReturn(Password::INVALID_TOKEN);

        $action = new ResetPasswordAction();

        $result = $action->execute([
            'email' => 'jan@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'token' => 'invalid-token',
        ]);

        $this->assertFalse($result);
    }
}
