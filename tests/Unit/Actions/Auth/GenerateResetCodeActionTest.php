<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\GenerateResetCodeAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GenerateResetCodeActionTest extends TestCase
{
    use RefreshDatabase;

    public function testItGeneratesSixDigitCodeAndPersistsHashedToken(): void
    {
        $email = "jan@example.com";

        $action = new GenerateResetCodeAction();
        $code = $action->execute($email);

        $this->assertMatchesRegularExpression('/^\d{6}$/', $code);

        $record = DB::table("password_reset_tokens")->where("email", $email)->first();

        $this->assertNotNull($record);
        $this->assertTrue(Hash::check($code, $record->token));
        $this->assertNotNull($record->created_at);
    }

    public function testItUpdatesExistingTokenForSameEmail(): void
    {
        $email = "jan@example.com";

        DB::table("password_reset_tokens")->insert([
            "email" => $email,
            "token" => Hash::make("123456"),
            "created_at" => now()->subHour(),
        ]);

        $action = new GenerateResetCodeAction();
        $code = $action->execute($email);

        $record = DB::table("password_reset_tokens")->where("email", $email)->first();

        $this->assertTrue(Hash::check($code, $record->token));
    }
}
