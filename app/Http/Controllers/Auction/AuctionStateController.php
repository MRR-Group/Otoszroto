<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionStateRequest;
use Otoszroto\Models\AuctionState;

class AuctionStateController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/AuctionState", []);
    }

    public function store(CreateAuctionStateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $auction_state = new AuctionState($validated);
        $auction_state->save();

        return redirect()->route("home")->with(["message" => "Auction state has been created."]);
    }
}
