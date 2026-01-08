<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ChangePasswordAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordActionTest extends TestCase
{
    use RefreshDatabase;

    public function testItReturnsFalseWhenCurrentPasswordIsInvalid(): void
    {
        $user = User::query()->create([
            "firstname" => "Jan",
            "surname" => "Kowalski",
            "phone" => "123123123",
            "email" => "jan@example.com",
            "password" => "password123",
        ]);

        $action = new ChangePasswordAction();
        $result = $action->execute($user, "wrong-password", "newpassword123");

        $this->assertFalse($result);
        $this->assertTrue(Hash::check("password123", $user->password));
    }

    public function testItUpdatesPasswordAndReturnsTrueWhenCurrentPasswordIsValid(): void
    {
        $user = User::query()->create([
            "firstname" => "Jan",
            "surname" => "Kowalski",
            "phone" => "123123123",
            "email" => "jan@example.com",
            "password" => "password123",
        ]);

        $action = new ChangePasswordAction();
        $result = $action->execute($user, "password123", "newpassword123");

        $this->assertTrue($result);
        $this->assertTrue(Hash::check("newpassword123", $user->fresh()->password));
    }
}
