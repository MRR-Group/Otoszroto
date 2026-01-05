<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Illuminate\Http\UploadedFile;
use Otoszroto\Models\Auction;

class AddImageToAuctionAction
{
    public function execute(Auction $auction, UploadedFile $uploadedFile): bool
    {
        $stored = $uploadedFile->storeAs("", $auction->id . ".png", "auctionImage");

        return $stored !== false;
    }
}
