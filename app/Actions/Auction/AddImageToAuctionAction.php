<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Models\Auction;
use Illuminate\Http\UploadedFile;

class AddImageToAuctionAction
{
    public function execute(Auction $auction, UploadedFile $uploadedFile): bool
    {
        $stored = $uploadedFile->storeAs("", $auction->id . ".png", "auctionImage");

        return $stored !== false;
    }
}
