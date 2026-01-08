<?php

declare(strict_types=1);

namespace App\Enums;

enum CategoryType: string
{
    case ENGINE = "Silnik";
    case FUEL_SYSTEM = "Układ paliwowy";
    case COOLING = "Układ chłodzenia";
    case EXHAUST = "Układ wydechowy";
    case BRAKES = "Układ hamulcowy";
    case SUSPENSION = "Zawieszenie";
    case STEERING = "Układ kierowniczy";
    case GEARBOX = "Skrzynia biegów";
    case CLUTCH = "Sprzęgło";
    case BODY = "Nadwozie";
    case INTERIOR = "Wnętrze";
    case ELECTRICAL = "Układ elektryczny";
    case LIGHTING = "Oświetlenie";
    case AC = "Klimatyzacja";
    case WHEELS = "Opony i koła";
    case FILTERS = "Filtry";
    case FLUIDS = "Płyny i oleje";
    case ACCESSORIES = "Akcesoria";
    case AXLE = "Mosty";
    case DOORS = "Drzwi";

    /**
     * @return array<string>
     */
    public static function labels(): array
    {
        return array_map(fn(self $c) => $c->value, self::cases());
    }
}
