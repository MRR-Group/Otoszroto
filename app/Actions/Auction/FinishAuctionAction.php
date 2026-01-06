<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Enums\AuctionState;
use App\Models\Auction;

class FinishAuctionAction
{
    public function execute(Auction $auction): Auction
    {
        $auction->auction_state = AuctionState::FINISHED;
        $auction->save();

        return $auction;
    }
}
