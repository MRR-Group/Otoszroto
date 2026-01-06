<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            "reporter_id" => User::factory(),
            "auction_id" => Auction::factory(),
            "reason" => fake()->text(200),
            "resolved_at" => null,
        ];
    }
}
