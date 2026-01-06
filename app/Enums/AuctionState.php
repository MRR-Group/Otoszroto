<?php

declare(strict_types=1);

namespace App\Enums;

enum AuctionState: string
{
    case ACTIVE = "aktywna";
    case FINISHED = "zakończona";
    case CANCELLED = "anulowana";
}
