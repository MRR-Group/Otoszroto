<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\CarModel;

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
