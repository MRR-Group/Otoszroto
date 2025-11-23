<?php

declare(strict_types=1);

namespace Otoszroto\Enums;

enum AuctionStateName: string
{
    case ACTIVE = "active";
    case FINISHED = "finished";
    case CANCELLED = "cancelled";
}
