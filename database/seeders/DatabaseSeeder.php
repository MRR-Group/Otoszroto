<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Otoszroto\Models\User;

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
        ]);

        if (!User::where('email', 'example@mrrgroup.pl')->exists()) {
            User::factory()->count(1)->create([
                "firstname" => "User",
                "surname" => "Example",
                "email" => "example@mrrgroup.pl",
                "password" => Hash::make("example@mrrgroup.pl")
            ]);
        }
    }
}
