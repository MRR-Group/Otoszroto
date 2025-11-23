<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Enums\AuctionStateName;
use Otoszroto\Models\AuctionState;

class AuctionStatesSeeder extends Seeder
{
    public function run(): void
    {
        $conditionStates = AuctionStateName::cases();

        $formatArray = array_map(fn($state) => ["name" => $state->value], $conditionStates);

        AuctionState::insert($formatArray);
    }
}
