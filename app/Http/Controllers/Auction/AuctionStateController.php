<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateAuctionStateAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionStateRequest;

class AuctionStateController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateAuctionState", []);
    }

    public function store(CreateAuctionStateRequest $request, CreateAuctionStateAction $createAuctionStateAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $createAuctionStateAction->execute($validated);

        return $success
            ? redirect()->route("auction.state.create")->with(["message" => "Auction state has been created."])
            : redirect()->route("auction.state.create")->with(["message" => "Invalid request."])->withInput();
    }
}
