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
            "Silnik",
            "Układ paliwowy",
            "Układ chłodzenia",
            "Układ wydechowy",
            "Układ hamulcowy",
            "Zawieszenie",
            "Układ kierowniczy",
            "Skrzynia biegów",
            "Sprzęgło",
            "Nadwozie",
            "Wnętrze",
            "Układ elektryczny",
            "Oświetlenie",
            "Klimatyzacja",
            "Opony i koła",
            "Filtry",
            "Płyny i oleje",
            "Akcesoria",
        ];

        $formatArray = array_map(fn($data) => ["name" => $data], $categoryArray);

        Category::insert($formatArray);
    }
}
