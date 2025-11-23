<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateAuctionAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionRequest;

class AuctionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateAuction", []);
    }

    public function store(CreateAuctionRequest $request, CreateAuctionAction $createAuctionAction): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $success = $createAuctionAction->execute($user, $validated);

        return $success
            ? redirect()->route("auction.create")->with(["message" => "Auction has been created."])
            : redirect()->route("auction.create")->with(["message" => "Invalid request."])->withInput();
    }
}
