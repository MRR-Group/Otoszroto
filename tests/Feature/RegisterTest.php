<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_renders(): void
    {
        $response = $this->get(route('auth.register.create'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auth/Register')
        );
    }

    public function test_register_requires_unique_email_and_phone(): void
    {
        User::query()->create([
            'firstname' => 'A',
            'surname' => 'B',
            'phone' => '111222333',
            'email' => 'taken@example.com',
            'password' => 'password123',
        ]);

        $payload = [
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111222333',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->from(route('auth.register.create'))
            ->post(route('auth.register.store'), $payload);

        $response->assertRedirect(route('auth.register.create'));
        $response->assertSessionHasErrors(['email', 'phone']);
    }

    public function test_register_requires_password_confirmation(): void
    {
        $payload = [
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ];

        $response = $this->from(route('auth.register.create'))
            ->post(route('auth.register.store'), $payload);

        $response->assertRedirect(route('auth.register.create'));
        $response->assertSessionHasErrors(['password']);
    }

    public function test_register_requires_min_password_length(): void
    {
        $payload = [
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'short7',
            'password_confirmation' => 'short7',
        ];

        $response = $this->from(route('auth.register.create'))
            ->post(route('auth.register.store'), $payload);

        $response->assertRedirect(route('auth.register.create'));
        $response->assertSessionHasErrors(['password']);
    }

    public function test_register_can_fail_email_validation_due_to_dns_check_in_environment(): void
    {
        $payload = [
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->from(route('auth.register.create'))
            ->post(route('auth.register.store'), $payload);

        $response->assertRedirect(route('auth.register.create'));
        $response->assertSessionHasErrors(['email']);
    }
}
