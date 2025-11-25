<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otoszroto\Enums\AuctionState;
use Otoszroto\Enums\Condition;
use Otoszroto\Models\Auction;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Category;
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
            "photo_url" => fake()->imageUrl(),
            "price" => fake()->randomFloat(2, 100, 10000),
            "owner_id" => User::factory(),
            "model_id" => CarModel::inRandomOrder()->first()->id,
            "category_id" => Category::inRandomOrder()->first()->id,
            "condition" => fake()->randomElement(Condition::cases()),
            "auction_state" => fake()->randomElement(AuctionState::cases()),
        ];
    }
}
