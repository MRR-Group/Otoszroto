<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuctionPolicy
{
    public function update(User $user, Auction $auction): Response
    {
        return $user->id === $auction->owner_id
            ? Response::allow()
            : Response::deny();
    }

    public function report(User $user, Auction $auction): Response
    {
        $alreadyReported = $auction->reports()
            ->where("reporter_id", $user->id)
            ->exists();

        if ($user->id === $auction->owner_id) {
            return Response::deny("Nie można zgłosić własnej aukcji.");
        }

        if ($alreadyReported) {
            return Response::deny("Aukcja została już przez Ciebie zgłoszona.");
        }

        return Response::allow();
    }
}
