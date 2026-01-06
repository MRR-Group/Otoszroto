<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        config([
            'platform.models.user' => \App\Models\User::class,
        ]);
    }

    public function boot(): void
    {
    }
}
