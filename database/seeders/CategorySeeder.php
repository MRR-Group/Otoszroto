<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryArray = [
            "Category1",
            "Category2",
            "Category3",
        ];

        $formatArray = array_map(fn($data) => ["name" => $data], $categoryArray);

        Category::insert($formatArray);
    }
}
