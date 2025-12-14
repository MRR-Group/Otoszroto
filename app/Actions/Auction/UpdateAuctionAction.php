<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Auction;

class UpdateAuctionAction
{
    public function execute(Auction $auction, array $auctionData): Auction
    {
        $auction->fill($auctionData);
        $auction->save();

        return $auction;
    }
}
