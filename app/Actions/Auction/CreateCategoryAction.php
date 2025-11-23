<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Category;

class CreateCategoryAction
{
    public function execute(array $validated): bool
    {
        $category = new Category($validated);
        $category->save();

        return true;
    }
}
