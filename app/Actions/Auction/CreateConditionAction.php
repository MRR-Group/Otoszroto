<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Condition;

class CreateConditionAction
{
    public function execute(array $validated): bool
    {
        $condition = new Condition($validated);
        $condition->save();

        return true;
    }
}
