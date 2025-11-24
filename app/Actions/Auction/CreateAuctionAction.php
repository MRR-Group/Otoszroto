<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Enums\AuctionStateName;
use Otoszroto\Models\Auction;
use Otoszroto\Models\User;

class CreateAuctionAction
{
    public function execute(User $user, array $validated): Auction
    {
        $auction = new Auction($validated);
        $auction->owner_id = $user->id;
        $auction->auction_state = AuctionStateName::ACTIVE;
        $auction->save();

        return $auction;
    }
}
