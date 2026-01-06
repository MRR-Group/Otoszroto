<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Actions\Auth\GenerateResetCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;

class ForgotPasswordController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auth/ForgotPassword", []);
    }

    public function store(ForgotPasswordRequest $request, GenerateResetCodeAction $generateResetCodeAction): RedirectResponse
    {
        $validated = $request->validated();
        $email = $validated["email"];

        $code = $generateResetCodeAction->execute($email);

        $user = User::query()->where("email", $email)->first();
        $user?->notify(new ForgotPasswordNotification($code));

        return redirect()->route("auth.resetPassword.create")->with(["message" => "If your email exists, we have sent you a code to reset your password."]);
    }
}
