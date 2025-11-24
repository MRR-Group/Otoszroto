<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Enums\AuctionStateName;
use Otoszroto\Http\Resources\AuctionResource;
use Otoszroto\Models\Auction;
use Otoszroto\Models\User;

class CreateAuctionAction
{
    public function execute(User $user, array $validated): AuctionResource
    {
        $auction = new Auction($validated);
        $auction->owner_id = $user->id;
        $auction->auction_state = AuctionStateName::ACTIVE;
        $auction->save();

        return new AuctionResource($auction);
    }
}
