<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Models\Auction;

class UpdateAuctionAction
{
    public function execute(Auction $auction, array $auctionData): Auction
    {
        $auction->fill($auctionData);
        $auction->save();

        return $auction;
    }
}
