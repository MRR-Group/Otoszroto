<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Models\Brand;
use Otoszroto\Models\CarModel;

class BrandAndModelsSeeder extends Seeder
{
    public function run(): void
    {
        $brandsWithModelsArray = [
            "Brand1" => [
                "Car1",
                "Car2",
                "Car3",
            ],
            "Brand2" => [
                "Car1",
                "Car2",
                "Car3",
            ],
            "Brand3" => [
                "Car1",
                "Car2",
                "Car3",
            ],
        ];

        foreach ($brandsWithModelsArray as $brandName => $carModels) {
            $brand = Brand::create(["name" => $brandName]);

            foreach ($carModels as $model) {
                CarModel::create(["name" => $model, "brand_id" => $brand->id]);
            }
        }
    }
}
