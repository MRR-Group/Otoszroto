<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Otoszroto\Models\Auction;
use Otoszroto\Models\User;

class AuctionPolicy
{
    public function update(User $user, Auction $auction): Response
    {
        return $user->id === $auction->owner_id
            ? Response::allow()
            : Response::deny();
    }
}
