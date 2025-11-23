<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\CarModel;

class CreateCarModelAction
{
    public function execute(array $validated): bool
    {
        $car_model = new CarModel($validated);
        $car_model->save();

        return true;
    }
}
