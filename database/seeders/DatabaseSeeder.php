<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandAndModelsSeeder::class,
            CategorySeeder::class,
            AuctionSeeder::class,
            ReportSeeder::class,
        ]);

        if (!User::where("email", "example@mrrgroup.pl")->exists()) {
            User::factory()->count(1)->create([
                "firstname" => "User",
                "surname" => "Example",
                "email" => "example@mrrgroup.pl",
                "password" => Hash::make("example@mrrgroup.pl"),
            ]);
        }
    }
}
