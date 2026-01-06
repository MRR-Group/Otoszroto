<?php

declare(strict_types=1);

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Otoszroto\Enums\Permission;
use Otoszroto\Http\Controllers\Auction\AuctionController;
use Otoszroto\Http\Controllers\Auction\ReportController;
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

Route::get("/auctions", [AuctionController::class, "index"])->name("auctions.index");

Route::middleware("auth")->group(function (): void {
    Route::post("/logout", [LogoutController::class, "logout"])->name("auth.logout");
    Route::get("/auctions/create", [AuctionController::class, "create"])->name("auctions.create")->middleware([Authorize::using(Permission::CreateAuction)]);
    Route::post("/auctions", [AuctionController::class, "store"])->name("auctions.store");
    Route::get("/auctions/{auction}/edit", [AuctionController::class, "edit"])->name("auctions.edit");
    Route::patch("/auctions/{auction}", [AuctionController::class, "update"])->name("auctions.update");
    Route::patch("/auctions/{auction}/finish", [AuctionController::class, "finish"])->name("auctions.finish");
    Route::patch("/auctions/{auction}/cancel", [AuctionController::class, "cancel"])->name("auctions.cancel");
    Route::get("/auctions/{auction}/report", [ReportController::class, "create"])->name("auctions.report.create");
    Route::post("/auctions/{auction}/report", [ReportController::class, "store"])->name("auctions.report.store");
    Route::get("/reports", [ReportController::class, "index"])->name("reports.index")->middleware([Authorize::using(Permission::ManageReports)]);
    Route::get("/reports/{report}", [ReportController::class, "show"])->name("reports.show")->middleware([Authorize::using(Permission::ManageReports)]);
    Route::get("/reports/{report}/resolve", [ReportController::class, "resolve"])->name("reports.resolve")->middleware([Authorize::using(Permission::ManageReports)]);
});

Route::get("/auctions/{auction}", [AuctionController::class, "show"])->name("auctions.show");
Route::get("/auctions/{id}/image", [AuctionController::class, "getImage"])->name("auction.image.show");
