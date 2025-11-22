<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Brand;

/**
 * @extends Factory<CarModel>
 */
class CarModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "brand_id" => Brand::factory(),
        ];
    }
}
