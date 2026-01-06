<?php

declare(strict_types=1);

namespace Otoszroto\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        config([
            'platform.models.user' => \Otoszroto\Models\User::class,
        ]);
    }

    public function boot(): void
    {
    }
}
