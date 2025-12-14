<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auth\ResetPasswordAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auth\ResetPasswordRequest;

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
            ? redirect()->route("auth.login.create")->with(["message" => "Your password has been reset."])
            : redirect()->route("auth.resetPassword.create")->with(["message" => "Reset token has expired or is invalid."])->withInput();
    }
}
