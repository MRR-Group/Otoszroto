<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        Auction::factory()->count(300)->create();
    }
}
