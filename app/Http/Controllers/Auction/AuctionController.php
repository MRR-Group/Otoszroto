<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateAuctionAction;
use Otoszroto\Helpers\SortHelper;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionRequest;
use Otoszroto\Http\Resources\AuctionResource;
use Otoszroto\Models\Auction;

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
        $auction = $createAuctionAction->execute($user, $validated);

        return redirect()->route("auction.create")->with(["message" => "Aukcja została utworzona."]);
    }

    public function index(SortHelper $sorter): Response
    {
        $auctions = Auction::query();

        $query = $sorter->sort($auctions, ["id", "name", "price", "model_id", "category_id", "condition", "auction_state", "updated_at", "created_at"], ["photo_url", "description", "owner_id"]);
        $query = $sorter->search($query, "name");

        return Inertia::render("Auction/AuctionPanel", [
            "auctions" => AuctionResource::collection($query->paginate()),
        ]);
    }
}
