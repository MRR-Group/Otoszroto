<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Enums\AuctionState;
use Otoszroto\Models\Auction;
use Otoszroto\Models\User;

class CreateAuctionAction
{
    public function execute(User $user, array $auctionData): Auction
    {
        $auction = new Auction($auctionData);
        $auction->owner_id = $user->id;
        $auction->auction_state = AuctionState::ACTIVE;
        $auction->save();

        return $auction;
    }
}
