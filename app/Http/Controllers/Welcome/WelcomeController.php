<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Welcome;

use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Enums\AuctionState;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Resources\AuctionResource;
use Otoszroto\Models\Auction;

class WelcomeController extends Controller
{
    public function index(): Response
    {
        $auctions = Auction::query()->with(["category", "model.brand", "owner"])->where("auction_state", "=", AuctionState::ACTIVE)->orderByDesc("created_at")->limit(3)->get();

        return Inertia::render("Welcome", [
            "auctions" => AuctionResource::collection($auctions)->resolve(),
        ]);
    }
}
