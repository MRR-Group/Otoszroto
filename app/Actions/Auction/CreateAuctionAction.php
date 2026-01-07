<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Enums\AuctionState;
use App\Models\Auction;
use App\Models\User;

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
