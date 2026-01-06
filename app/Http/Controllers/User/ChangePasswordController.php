<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\Auth\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ChangePasswordController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("User/ChangePassword", []);
    }

    public function store(ChangePasswordRequest $request, ChangePasswordAction $changePasswordAction): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $currentPassword = $validated["current_password"];
        $newPassword = $validated["password"];

        $success = $changePasswordAction->execute(
            $user,
            $currentPassword,
            $newPassword,
        );

        return $success
            ? redirect()->route("home")->with(["message" => "Your password has been changed."])
            : redirect()->route("user.changePassword.create")->with(["error" => "Your current password is invalid."]);
    }
}
