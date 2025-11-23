<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\AuctionState;

class CreateAuctionStateAction
{
    public function execute(array $validated): bool
    {
        $auction_state = new AuctionState($validated);
        $auction_state->save();

        return true;
    }
}
