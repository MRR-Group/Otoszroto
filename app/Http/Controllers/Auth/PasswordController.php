<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Otoszroto\Actions\Auth\ChangePasswordAction;
use Otoszroto\Actions\Auth\GenerateResetCodeAction;
use Otoszroto\Actions\Auth\ResetPasswordAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auth\ChangePasswordRequest;
use Otoszroto\Http\Requests\Auth\ForgotPasswordRequest;
use Otoszroto\Http\Requests\Auth\ResetPasswordRequest;
use Otoszroto\Models\User;
use Otoszroto\Notifications\ForgotPasswordNotification;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    public function sendResetEmail(ForgotPasswordRequest $request, GenerateResetCodeAction $generateResetCodeAction): JsonResponse
    {
        $validated = $request->validated();
        $email = $validated["email"];

        $code = $generateResetCodeAction->execute($email);

        $user = User::query()->where("email", $email)->first();
        $user?->notify(new ForgotPasswordNotification($code));

        return response()->json([], Response::HTTP_OK);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction): JsonResponse
    {
        $validated = $request->validated();
        $success = $resetPasswordAction->execute($validated);

        return $success
            ? response()->json([], Response::HTTP_OK)
            : response()->json([], Response::HTTP_BAD_REQUEST);
    }

    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $changePasswordAction): JsonResponse
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
            ? response()->json([], Response::HTTP_OK)
            : response()->json([], Response::HTTP_FORBIDDEN);
    }
}
