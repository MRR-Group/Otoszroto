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
            "FSO" => [
                "Warszawa",
                "Syrena 100",
                "Syrena 101",
                "Syrena 102",
                "Syrena 103",
                "Syrena 104",
                "Syrena 105",
                "Syrena Bosto",
                "Syrena R20",
                "Polski Fiat 125p",
                "Polonez",
                "Polonez MR78",
                "Polonez Borewicz",
                "Polonez Caro",
                "Polonez Caro Plus",
                "Polonez Atu",
                "Polonez Atu Plus",
                "Polonez Truck",
                "Polonez Cargo",
                "Polonez Kombi",
            ],

            "Daewoo" => [
                "Tico", "Matiz", "Lanos", "Nubira", "Leganza",
                "Espero", "Tacuma", "Evanda", "Kalos", "Tarpan Honker",
            ],

            "FSC" => [
                "Zuk",
                "Lublin",
                "Lublin II",
                "Honker",
            ],

            "FSD" => [
                "Nysa",
            ],

            "FSM" => [
                "126p",
            ],

            "Lada" => [
                "1200",
                "1300",
                "1500",
                "1600",
                "Niva",
                "Samara",
                "Kalina",
                "Priora",
                "Granta",
                "Vesta",
                "Largus",
            ],

            "Robur" => [
                "LO 2500",
                "LO 3000",
                "LO 2002 A",
                "LO 2002 A Bus",
                "LD 3000",
                "LD 2002",
                "LO 1800",
            ],

            "UAZ" => [
                "469",
                "452",
                "Patriot",
            ],

            "GAZ" => [
                "Volga",
                "Gazelle",
            ],

            "Izh" => [
                "2125 Kombi",
            ],

            "FSR" => [
                "Tarpan 233",
                "Tarpan 239",
                "Tarpan Honker",
            ],

            "Audi" => [
                "A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8",
                "S1", "S3", "S4", "S5", "S6", "S7", "S8",
                "RS2", "RS3", "RS4", "RS5", "RS6", "RS7", "RS e-tron GT",
                "Q2", "Q3", "Q4 e-tron", "Q5", "Q7", "Q8",
                "SQ2", "SQ5", "SQ7", "SQ8", "RS Q3", "RS Q8",
                "TT", "TTS", "TT RS", "R8",
                "e-tron", "e-tron GT",
                "A4 Allroad", "A6 Allroad",
            ],

            "BMW" => [
                "1 Series", "2 Series", "3 Series", "4 Series", "5 Series", "6 Series", "7 Series", "8 Series",
                "X1", "X2", "X3", "X4", "X5", "X6", "X7",
                "Z3", "Z4", "Z8",
                "M2", "M3", "M4", "M5", "M6", "M8",
                "X3 M", "X4 M", "X5 M", "X6 M",
                "i3", "i4", "i5", "i7", "i8", "iX", "iX1", "iX3",
                "2 Series Gran Coupe", "4 Series Gran Coupe", "6 Series Gran Coupe", "8 Series Gran Coupe",
            ],

            "Mercedes-Benz" => [
                "A-Class", "B-Class", "C-Class", "E-Class", "S-Class",
                "CLA", "CLS",
                "GLA", "GLB", "GLC", "GLE", "GLS",
                "G-Class",
                "AMG GT",
                "EQC", "EQA", "EQB", "EQE", "EQS",
            ],

            "Volkswagen" => [
                "Golf", "Polo", "Passat", "Jetta", "Arteon",
                "Tiguan", "Touareg", "T-Roc", "Taigo", "T-Cross",
                "Touran", "Sharan",
                "Transporter", "Multivan", "Caravelle", "Caddy", "Crafter",
                "Up",
                "ID.3", "ID.4", "ID.5", "ID.7", "ID.Buzz",
            ],

            "Skoda" => [
                "Octavia", "Superb", "Fabia", "Rapid", "Scala",
                "Kamiq", "Karoq", "Kodiaq",
                "Citigo", "Roomster", "Yeti",
                "Enyaq",
                "Felicia", "Favorit",
            ],

            "SEAT" => [
                "Ibiza", "Leon", "Toledo", "Cordoba",
                "Altea", "Arona", "Ateca", "Tarraco",
                "Mii",
            ],

            "Cupra" => [
                "Formentor", "Ateca", "Leon", "Born", "Tavascan",
            ],

            "Opel" => [
                "Corsa", "Astra", "Insignia", "Vectra",
                "Kadett", "Omega",
                "Zafira", "Meriva",
                "Mokka", "Crossland", "Grandland",
                "Combo", "Vivaro", "Movano",
            ],

            "Ford" => [
                "Fiesta", "Focus", "Mondeo", "Mustang",
                "Kuga", "Puma", "Edge", "Explorer",
                "Ranger", "Transit", "Transit Custom", "Tourneo",
                "S-Max", "Galaxy",
            ],

            "Toyota" => [
                "Corolla", "Camry", "Avensis", "Yaris", "Auris",
                "RAV4", "C-HR", "Highlander", "Land Cruiser",
                "Hilux", "ProAce",
                "Supra", "GT86",
                "Prius", "Mirai",
            ],

            "Honda" => [
                "Civic", "Accord", "Jazz", "Integra",
                "CR-V", "HR-V", "ZR-V",
                "Prelude", "S2000",
                "Type R",
            ],

            "Nissan" => [
                "Micra", "Almera", "Pulsar",
                "Sunny",
                "Qashqai", "Juke", "X-Trail", "Pathfinder",
                "Navara",
                "Leaf", "Ariya",
                "GT-R", "350Z", "370Z",
            ],

            "Mazda" => [
                "Mazda2", "Mazda3", "Mazda6",
                "CX-3", "CX-30", "CX-5", "CX-60", "CX-80", "CX-9",
                "MX-5",
                "RX-7", "RX-8",
            ],

            "Mitsubishi" => [
                "Colt", "Lancer", "Galant",
                "Outlander", "ASX", "Eclipse Cross",
                "Pajero", "Pajero Sport",
                "L200",
            ],

            "Subaru" => [
                "Impreza", "Legacy", "Outback",
                "Forester", "XV", "Crosstrek",
                "WRX", "BRZ",
            ],

            "Suzuki" => [
                "Swift", "Baleno", "Ignis",
                "Vitara", "SX4", "S-Cross",
                "Jimny",
            ],

            "Hyundai" => [
                "i10", "i20", "i30", "Elantra", "Sonata",
                "Kona", "Tucson", "Santa Fe", "Palisade",
                "Ioniq", "Ioniq 5", "Ioniq 6",
            ],

            "Kia" => [
                "Picanto", "Rio", "Ceed", "Proceed",
                "Sportage", "Sorento", "Niro", "Stonic", "Seltos",
                "Stinger", "EV6", "EV9",
            ],

            "Volvo" => [
                "S60", "S90", "V60", "V90",
                "XC40", "XC60", "XC90",
                "C30", "V40",
                "EX30", "EX90",
            ],

            "Renault" => [
                "Clio", "Megane", "Laguna", "Talisman",
                "Captur", "Kadjar", "Arkana", "Austral", "Espace",
                "Scenic",
                "Twingo",
                "Kangoo", "Trafic", "Master",
                "Zoe",
            ],

            "Peugeot" => [
                "106", "107", "108",
                "205", "206", "207", "208", "209",
                "306", "307", "308",
                "406", "407", "508",
                "2008", "3008", "5008",
                "Partner", "Rifter", "Expert", "Boxer",
            ],

            "Citroen" => [
                "C1", "C2", "C3", "C4", "C5", "C6",
                "C3 Aircross", "C4 Cactus", "C5 Aircross",
                "Berlingo", "Jumpy", "Jumper",
                "DS3", "DS4", "DS5",
            ],

            "Fiat" => [
                "500", "500L", "500X",
                "Panda", "Punto", "Grande Punto", "Tipo",
                "Bravo", "Brava", "Stilo",
                "Croma",
                "Doblo", "Ducato", "Fiorino",
                "126p",
            ],

            "Alfa Romeo" => [
                "Giulia", "Stelvio", "Tonale",
                "156", "159", "147", "145",
                "Giulietta", "MiTo",
                "Brera", "Spider",
            ],

            "Lancia" => [
                "Delta", "Ypsilon", "Thema", "Kappa",
                "Lybra", "Dedra",
            ],

            "Saab" => [
                "900", "9000", "9-3", "9-5",
            ],

            "Dacia" => [
                "Logan", "Sandero", "Duster",
                "Lodgy", "Dokker",
                "Jogger", "Spring",
            ],

            "Jaguar" => [
                "XE", "XF", "XJ",
                "F-Type",
                "E-Pace", "F-Pace", "I-Pace",
            ],

            "Land Rover" => [
                "Defender", "Discovery", "Discovery Sport",
                "Range Rover", "Range Rover Sport", "Range Rover Velar", "Range Rover Evoque",
            ],

            "MINI" => [
                "Mini Hatch", "Mini Clubman", "Mini Countryman", "Mini Cabrio",
            ],

            "Porsche" => [
                "911", "Boxster", "Cayman",
                "Panamera",
                "Cayenne", "Macan",
                "Taycan",
            ],

            "Tesla" => [
                "Model S", "Model 3", "Model X", "Model Y", "Cybertruck",
            ],

            "Jeep" => [
                "Wrangler", "Cherokee", "Grand Cherokee",
                "Compass", "Renegade",
                "Gladiator",
            ],

            "Chevrolet" => [
                "Camaro", "Corvette",
                "Cruze", "Aveo",
                "Tahoe", "Suburban",
            ],

            "Lexus" => [
                "IS", "ES", "GS", "LS",
                "UX", "NX", "RX", "GX", "LX",
                "RC", "LC",
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
