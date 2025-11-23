<?php

declare(strict_types=1);

namespace Otoszroto\Enums;

enum ConditionName: string
{
    case BRAND_NEW = "brand_new";
    case NEARLY_NEW = "nearly_new";
    case GOOD_CONDITION = "good_condition";
    case FAIR_CONDITION = "fair_condition";
    case SALVAGED = "salvaged";
    case FOR_PARTS = "for_parts";
}
