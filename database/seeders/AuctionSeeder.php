<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Models\Auction;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        Auction::factory()->count(100)->create();
    }
}
