<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Auction;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        Auction::factory()->count(300)->create();
    }
}
