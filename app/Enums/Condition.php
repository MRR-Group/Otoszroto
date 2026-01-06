<?php

declare(strict_types=1);

namespace App\Enums;

enum Condition: string
{
    case BRAND_NEW = "fabrycznie nowy";
    case NEARLY_NEW = "prawie nowy";
    case GOOD_CONDITION = "w dobrym stanie";
    case FAIR_CONDITION = "w zadawalającym stanie";
    case SALVAGED = "uszkodzony";
    case FOR_PARTS = "na części";
}
