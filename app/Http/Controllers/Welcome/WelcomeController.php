<?php

declare(strict_types=1);

namespace App\Http\Controllers\Welcome;

use App\Enums\AuctionState;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuctionResource;
use App\Models\Auction;
use Inertia\Inertia;
use Inertia\Response;

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
