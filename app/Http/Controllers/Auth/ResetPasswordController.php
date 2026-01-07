<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auth/ResetPassword", []);
    }

    public function store(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $resetPasswordAction->execute($validated);

        return $success
            ? redirect()->route("login")->with(["message" => "Your password has been reset."])
            : redirect()->route("auth.resetPassword.create")->with(["message" => "Reset token has expired or is invalid."])->withInput();
    }
}
