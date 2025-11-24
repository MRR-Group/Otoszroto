<?php

declare(strict_types=1);

namespace Otoszroto\Enums;

enum AuctionStateName: string
{
    case ACTIVE = "aktywna";
    case FINISHED = "zakończona";
    case CANCELLED = "anulowana";
}
