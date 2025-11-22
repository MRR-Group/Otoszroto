<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Otoszroto\Http\Controllers\Auth\ForgotPasswordController;
use Otoszroto\Http\Controllers\Auth\LoginController;
use Otoszroto\Http\Controllers\Auth\LogoutController;
use Otoszroto\Http\Controllers\Auth\RegisterController;
use Otoszroto\Http\Controllers\Auth\ResetPasswordController;
use Otoszroto\Http\Controllers\User\ChangePasswordController;
use Otoszroto\Http\Controllers\Auction\AuctionController;
use Otoszroto\Http\Controllers\Auction\AuctionStateController;
use Otoszroto\Http\Controllers\Auction\BrandController;
use Otoszroto\Http\Controllers\Auction\CarModelController;
use Otoszroto\Http\Controllers\Auction\CategoryController;
use Otoszroto\Http\Controllers\Auction\ConditionController;

Route::get("/", fn(): Response => inertia("Welcome"))->name("home");

Route::get("/register", [RegisterController::class, "create"])->name("auth.register.create");
Route::post("/register", [RegisterController::class, "store"])->name("auth.register.store");

Route::get("/login", [LoginController::class, "create"])->name("auth.login.create");
Route::post("/login", [LoginController::class, "store"])->name("auth.login.store");

Route::get("/forgot-password", [ForgotPasswordController::class, "create"])->name("auth.forgotPassword.create");
Route::post("/forgot-password", [ForgotPasswordController::class, "store"])->name("auth.forgotPassword.store");

Route::get("/reset-password", [ResetPasswordController::class, "create"])->name("auth.resetPassword.create");
Route::post("/reset-password", [ResetPasswordController::class, "store"])->name("auth.resetPassword.store");

Route::get("/user/change-password", [ChangePasswordController::class, "create"])->name("user.changePassword.create");
Route::post("/user/change-password", [ChangePasswordController::class, "store"])->name("user.changePassword.store");

Route::post("/logout", [LogoutController::class, "logout"])->name("auth.logout");

Route::get("/auction", [AuctionController::class, "create"])->name("auction.create");
Route::post("/auction", [AuctionController::class, "store"])->name("auction.store");

Route::get("/auction/state", [AuctionStateController::class, "create"])->name("auction.auctionState.create");
Route::post("/auction/state", [AuctionStateController::class, "store"])->name("auction.auctionState.store");

Route::get("/auction/brand", [BrandController::class, "create"])->name("auction.brand.create");
Route::post("/auction/brand", [BrandController::class, "store"])->name("auction.brand.store");

Route::get("/auction/model", [CarModelController::class, "create"])->name("auction.model.create");
Route::post("/auction/model", [CarModelController::class, "store"])->name("auction.model.store");

Route::get("/auction/category", [CategoryController::class, "create"])->name("auction.category.create");
Route::post("/auction/category", [CategoryController::class, "store"])->name("auction.category.store");

Route::get("/auction/condition", [ConditionController::class, "create"])->name("auction.condition.create");
Route::post("/auction/condition", [ConditionController::class, "store"])->name("auction.condition.store");
