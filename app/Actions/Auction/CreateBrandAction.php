<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Brand;

class CreateBrandAction
{
    public function execute(array $validated): bool
    {
        $brand = new Brand($validated);
        $brand->save();

        return true;
    }
}
