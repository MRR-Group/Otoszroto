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
            "Audi" => [
                "A3",
                "A4",
                "A6",
                "A8",
                "Q3",
                "Q5",
                "Q7",
                "Q8",
                "TT",
                "RS6",
            ],
            "BMW" => [
                "1 Series",
                "3 Series",
                "5 Series",
                "7 Series",
                "X1",
                "X3",
                "X5",
                "X6",
                "M3",
                "M5",
            ],
            "Mercedes-Benz" => [
                "A-Class",
                "C-Class",
                "E-Class",
                "S-Class",
                "CLA",
                "GLA",
                "GLC",
                "GLE",
                "GLS",
                "AMG GT",
            ],
            "Volkswagen" => [
                "Golf",
                "Polo",
                "Passat",
                "Tiguan",
                "Touareg",
                "Arteon",
                "Transporter",
                "Up",
            ],
            "Toyota" => [
                "Corolla",
                "Camry",
                "RAV4",
                "Yaris",
                "Land Cruiser",
                "C-HR",
                "Supra",
                "Prius",
            ],
            "Honda" => [
                "Civic",
                "Accord",
                "CR-V",
                "HR-V",
                "Jazz",
                "Type R",
            ],
            "Ford" => [
                "Fiesta",
                "Focus",
                "Mondeo",
                "Mustang",
                "Kuga",
                "Ranger",
                "Explorer",
            ],
            "Hyundai" => [
                "i20",
                "i30",
                "Elantra",
                "Tucson",
                "Santa Fe",
                "Kona",
            ],
            "Kia" => [
                "Ceed",
                "Sportage",
                "Sorento",
                "Rio",
                "Stinger",
                "Niro",
            ],
            "Volvo" => [
                "S60",
                "S90",
                "V60",
                "V90",
                "XC40",
                "XC60",
                "XC90",
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
