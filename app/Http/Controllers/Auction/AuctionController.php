<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionRequest;
use Otoszroto\Models\Auction;

class AuctionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/Auction", []);
    }

    public function store(CreateAuctionRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $auction = new Auction($validated);
        $auction->owner_id = $user->id;
        $auction->save();

        return redirect()->route("home")->with(["message" => "Auction has been created."]);
    }
}
