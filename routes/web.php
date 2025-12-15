<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Otoszroto\Http\Controllers\Auction\AuctionController;
use Otoszroto\Http\Controllers\Auth\ForgotPasswordController;
use Otoszroto\Http\Controllers\Auth\LoginController;
use Otoszroto\Http\Controllers\Auth\LogoutController;
use Otoszroto\Http\Controllers\Auth\RegisterController;
use Otoszroto\Http\Controllers\Auth\ResetPasswordController;
use Otoszroto\Http\Controllers\User\ChangePasswordController;

Route::get("/", fn(): Response => inertia("Welcome"))->name("home");

Route::get("/register", [RegisterController::class, "create"])->name("auth.register.create");
Route::post("/register", [RegisterController::class, "store"])->name("auth.register.store");

Route::get("/login", [LoginController::class, "create"])->name("login");
Route::post("/login", [LoginController::class, "store"])->name("auth.login.store");

Route::get("/forgot-password", [ForgotPasswordController::class, "create"])->name("auth.forgotPassword.create");
Route::post("/forgot-password", [ForgotPasswordController::class, "store"])->name("auth.forgotPassword.store");

Route::get("/reset-password", [ResetPasswordController::class, "create"])->name("auth.resetPassword.create");
Route::post("/reset-password", [ResetPasswordController::class, "store"])->name("auth.resetPassword.store");

Route::get("/user/change-password", [ChangePasswordController::class, "create"])->name("user.changePassword.create");
Route::post("/user/change-password", [ChangePasswordController::class, "store"])->name("user.changePassword.store");

Route::post("/logout", [LogoutController::class, "logout"])->name("auth.logout");
Route::get("/auctions", [AuctionController::class, "index"])->name("auction.index");

Route::middleware("auth")->group(function (): void {
    Route::get("/auctions/create", [AuctionController::class, "create"])->name("auction.create");
    Route::post("/auctions", [AuctionController::class, "store"])->name("auction.store");
});
