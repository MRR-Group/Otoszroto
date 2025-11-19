<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Otoszroto\Http\Controllers\Auth\ForgotPasswordController;
use Otoszroto\Http\Controllers\Auth\LoginController;
use Otoszroto\Http\Controllers\Auth\LogoutController;
use Otoszroto\Http\Controllers\Auth\RegisterController;
use Otoszroto\Http\Controllers\Auth\ResetPasswordController;
use Otoszroto\Http\Controllers\User\ChangePasswordController;

Route::middleware("auth:sanctum")->get("/user", fn(Request $request): JsonResponse => new JsonResponse($request->user()));

Route::middleware(["auth:sanctum"])->group(function (): void {
    Route::post("/auth/logout", [LogoutController::class, "logout"])->name("logout");

    Route::post("/user/change-password", [ChangePasswordController::class, "changePassword"])->name("change-password");
});

Route::post("/auth/login", [LoginController::class, "create"])->name("login");
Route::post("/auth/register", [RegisterController::class, "register"])->name("register");
Route::post("/auth/forgot-password", [ForgotPasswordController::class, "sendResetEmail"])->name("forgot-password");
Route::post("/auth/reset-password", [ResetPasswordController::class, "resetPassword"])->name("reset-password");
