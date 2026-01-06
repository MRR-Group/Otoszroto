<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        config([
            "platform.models.user" => User::class,
        ]);
    }

    public function boot(): void
    {
    }
}
