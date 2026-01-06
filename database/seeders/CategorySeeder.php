<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

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

        $formattedArray = array_map(fn($data) => [
            "name" => $data,
            "created_at" => now(),
            "updated_at" => now(),
        ], $categoryArray);

        Category::insert($formattedArray);
    }
}
