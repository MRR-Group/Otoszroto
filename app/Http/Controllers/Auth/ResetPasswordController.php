<?php

namespace Otoszroto\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Otoszroto\Actions\Auth\ResetPasswordAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function create(): \Inertia\Response
    {
        return Inertia::render("Auth/ResetPassword", []);
    }

    public function store(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $resetPasswordAction->execute($validated);

        return $success
            ? redirect()->route("login")->with(["message" => "Your password has been reset."])
            : redirect()->route("login")->with(["message" => "Something went wrong. Please try again later."]);
    }
}
