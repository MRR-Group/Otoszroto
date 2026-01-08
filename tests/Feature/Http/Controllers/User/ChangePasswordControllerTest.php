<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\User;

use App\Actions\Auth\ChangePasswordAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ChangePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_password_page_renders_for_authenticated_user(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $response = $this->actingAs($user)->get(route('user.changePassword.create'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('User/ChangePassword')
        );
    }

    public function test_it_redirects_home_with_message_when_password_change_succeeds(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'oldpassword123',
        ]);

        $this->mock(ChangePasswordAction::class, function ($mock) use ($user): void {
            $mock->shouldReceive('execute')
                ->once()
                ->withArgs(function ($u, $current, $new) use ($user) {
                    return $u->id === $user->id
                        && $current === 'oldpassword123'
                        && $new === 'newpassword123';
                })
                ->andReturn(true);
        });

        $payload = [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($user)->post(route('user.changePassword.store'), $payload);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('message', 'Your password has been changed.');
    }

    public function test_it_redirects_back_with_error_when_current_password_is_invalid(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'oldpassword123',
        ]);

        $this->mock(ChangePasswordAction::class, function ($mock): void {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn(false);
        });

        $payload = [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($user)->from(route('user.changePassword.create'))
            ->post(route('user.changePassword.store'), $payload);

        $response->assertRedirect(route('user.changePassword.create'));
        $response->assertSessionHas('error', 'Your current password is invalid.');
    }
}
