<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use Illuminate\Support\Facades\Storage;

class GetDefaultAuctionImageAction
{
    public function execute(): ?string
    {
        $filename = "default.png";

        if (Storage::disk("auctionImage")->exists($filename)) {
            return Storage::disk("auctionImage")->get($filename);
        }

        return null;
    }
}
