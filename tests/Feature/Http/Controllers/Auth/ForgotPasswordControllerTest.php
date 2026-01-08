<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Actions\Auth\GenerateResetCodeAction;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_renders(): void
    {
        $response = $this->get(route('auth.forgotPassword.create'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auth/ForgotPassword')
        );
    }

    public function test_it_redirects_and_does_not_send_notification_when_user_does_not_exist(): void
    {
        Notification::fake();

        $this->mock(GenerateResetCodeAction::class, function ($mock): void {
            $mock->shouldReceive('execute')->once()->andReturn('123456');
        });

        $response = $this->post(route('auth.forgotPassword.store'), [
            'email' => 'missing@example.com',
        ]);

        $response->assertRedirect(route('auth.resetPassword.create'));
        $response->assertSessionHas('message', 'If your email exists, we have sent you a code to reset your password.');

        Notification::assertNothingSent();
    }

    public function test_it_sends_notification_when_user_exists(): void
    {
        Notification::fake();

        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $this->mock(GenerateResetCodeAction::class, function ($mock): void {
            $mock->shouldReceive('execute')->once()->andReturn('123456');
        });

        $response = $this->post(route('auth.forgotPassword.store'), [
            'email' => 'jan@example.com',
        ]);

        $response->assertRedirect(route('auth.resetPassword.create'));
        $response->assertSessionHas('message', 'If your email exists, we have sent you a code to reset your password.');

        Notification::assertSentTo($user, ForgotPasswordNotification::class, function ($notification) {
            return true;
        });
    }
}
