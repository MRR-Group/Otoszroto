<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Enums\ConditionName;
use Otoszroto\Models\Condition;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditionStates = ConditionName::cases();

        $formatArray = array_map(fn($state) => ["name" => $state->value], $conditionStates);

        Condition::insert($formatArray);
    }
}
