<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandAndModelsSeeder::class,
            CategorySeeder::class,
            AuctionSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
