<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateAuctionAction;
use Otoszroto\Actions\Auction\UpdateAuctionAction;
use Otoszroto\Helpers\SortHelper;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateAuctionRequest;
use Otoszroto\Http\Requests\Auction\UpdateAuctionRequest;
use Otoszroto\Http\Resources\AuctionResource;
use Otoszroto\Http\Resources\BrandResource;
use Otoszroto\Http\Resources\CategoryResource;
use Otoszroto\Http\Resources\ModelResource;
use Otoszroto\Models\Auction;
use Otoszroto\Models\Brand;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Otoszroto\Enums\AuctionState;

class AuctionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateAuction", []);
    }

    public function edit(Auction $auction): Response
    {
        $this->authorize("update", $auction);

        return Inertia::render("Auction/EditAuction", ["auction" => $auction]);
    }

    public function store(CreateAuctionRequest $request, CreateAuctionAction $createAuctionAction): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $createAuctionAction->execute($user, $validated);

        return redirect()->route("auction.create")->with(["message" => "Aukcja została utworzona."]);
    }

    public function show(Auction $auction): Response
    {
        $auction->load(['category', 'model.brand', 'owner']);

        return Inertia::render('Auction/ShowAuction', [
            'auction' => new AuctionResource($auction),
        ]);
    }

    public function index(SortHelper $sorter, Request $request): Response
    {
        $auctions = Auction::query()->with(["category", "model.brand", "owner"])->where("auction_state", "=", AuctionState::ACTIVE);
        $categories = Category::query()->get();
        $models = CarModel::query()->with("brand")->get();
        $brands = Brand::query()->get();
        $perPage = (int) request()->query('per_page', 10);

        $query = $sorter->sort($auctions, ["id", "name", "price", "created_at"], []);
        $query = $sorter->search($query, "name");
        $query = $this->filterCategory($query, $request);
        $query = $this->filterBrand($query, $request);
        $query = $this->filterModel($query, $request);
        $query = $this->filterCondition($query, $request);
        $query = $this->filterPriceMin($query, $request);
        $query = $this->filterPriceMax($query, $request);

        return Inertia::render("Auction/Auctions", [
            "auctions" => AuctionResource::collection($query->paginate($perPage)),
            "categories" => CategoryResource::collection($categories)->resolve(),
            "models" => ModelResource::collection($models)->resolve(),
            "brands" => BrandResource::collection($brands)->resolve(),
        ]);
    }

    private function filterCategory(Builder $query, Request $request): Builder
    {
        $category_id = $request->query("category", null);

        if ($category_id === null) {
            return $query;         
        }

        return $query->where(fn(Builder $query) => $query->where("category_id", "=", $category_id));
    }

    private function filterBrand(Builder $query, Request $request): Builder
    {
        $brandId = $request->query('brand');

        if ($brandId === null) {
            return $query;
        }

        return $query->whereHas('model', function (Builder $q) use ($brandId) {
            $q->where('brand_id', $brandId);
        });
    }

    private function filterModel(Builder $query, Request $request): Builder
    {
        $model_id = $request->query("model", null);

        if ($model_id === null) {
            return $query;         
        }

        return $query->where(fn(Builder $query) => $query->where("model_id", "=", $model_id));
    }

    private function filterCondition(Builder $query, Request $request): Builder
    {
        $condition = $request->query("condition", null);

        if ($condition === null) {
            return $query;         
        }

        return $query->where(fn(Builder $query) => $query->where("condition", "=", $condition));
    }

    private function filterPriceMin(Builder $query, Request $request): Builder
    {
        $min = $request->query("price_min", null);

        if ($min === null) {
            return $query;         
        }

        return $query->where(fn(Builder $query) => $query->where("price", ">=", $min));
    }

    private function filterPriceMax(Builder $query, Request $request): Builder
    {
        $max = $request->query("price_max", null);

        if ($max === null) {
            return $query;         
        }

        return $query->where(fn(Builder $query) => $query->where("price", "<=", $max));
    }

    public function update(UpdateAuctionRequest $request, UpdateAuctionAction $updateAuctionAction, Auction $auction): RedirectResponse
    {
        $this->authorize("update", $auction);
        $validated = $request->validated();
        $auction = $updateAuctionAction->execute($auction, $validated);

        return redirect()->route("auction.edit", ["auction" => $auction])->with(["message" => "Aukcja została edytowana."]);
    }
}
