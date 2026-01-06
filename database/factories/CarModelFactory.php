<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;

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
