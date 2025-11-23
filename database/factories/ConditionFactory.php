<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otoszroto\Enums\ConditionName;
use Otoszroto\Models\Condition;

/**
 * @extends Factory<Condition>
 */
class ConditionFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->randomElement(ConditionName::cases())->value,
        ];
    }
}
