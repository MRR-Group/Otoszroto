<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otoszroto\Models\Auction;
use Otoszroto\Models\AuctionState;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Category;
use Otoszroto\Models\Condition;
use Otoszroto\Models\User;

/**
 * @extends Factory<Auction>
 */
class AuctionFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "description" => fake()->paragraph(),
            "photo_url" => fake()->word(),
            "price" => fake()->randomDigit(),
            "owner_id" => User::factory(),
            "model_id" => CarModel::factory(),
            "category_id" => Category::factory(),
            "condition_id" => Condition::factory(),
            "auction_state_id" => AuctionState::factory(),
        ];
    }
}
