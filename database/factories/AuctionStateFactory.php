<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otoszroto\Models\AuctionState;

/**
 * @extends Factory<AuctionState>
 */
class AuctionStateFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
        ];
    }
}