<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Enums\AuctionState;
use Otoszroto\Models\Auction;

class CancelAuctionAction
{
    public function execute(Auction $auction): Auction
    {
        $auction->auction_state = AuctionState::CANCELLED;
        $auction->save();

        return $auction;
    }
}
