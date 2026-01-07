<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auction;

use App\Actions\Auction\AddImageToAuctionAction;
use App\Actions\Auction\CancelAuctionAction;
use App\Actions\Auction\CreateAuctionAction;
use App\Actions\Auction\FinishAuctionAction;
use App\Actions\Auction\GetAuctionImageAction;
use App\Actions\Auction\GetDefaultAuctionImageAction;
use App\Actions\Auction\UpdateAuctionAction;
use App\Enums\AuctionState;
use App\Helpers\SortHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auction\CreateAuctionRequest;
use App\Http\Requests\Auction\UpdateAuctionRequest;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ModelResource;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuctionController extends Controller
{
    public function create(): Response
    {
        $categories = Category::query()->get();
        $models = CarModel::query()->with("brand")->get();
        $brands = Brand::query()->get();

        return Inertia::render("Auction/CreateAuction", [
            "categories" => CategoryResource::collection($categories)->resolve(),
            "models" => ModelResource::collection($models)->resolve(),
            "brands" => BrandResource::collection($brands)->resolve(),
        ]);
    }

    public function edit(Auction $auction): Response | RedirectResponse
    {
        if ($auction->owner->id !== auth()->id()) {
            return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Nie możesz edytować nie swoich aukcji"]);
        }

        $auction->load(["category", "model.brand", "owner"]);
        $categories = Category::query()->get();
        $models = CarModel::query()->with("brand")->get();
        $brands = Brand::query()->get();

        return Inertia::render("Auction/EditAuction", [
            "auction" => AuctionResource::make($auction)->resolve(),
            "categories" => CategoryResource::collection($categories)->resolve(),
            "models" => ModelResource::collection($models)->resolve(),
            "brands" => BrandResource::collection($brands)->resolve(),
        ]);
    }

    public function store(CreateAuctionRequest $request, CreateAuctionAction $createAuctionAction, AddImageToAuctionAction $addImageToAuctionAction): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $auction = $createAuctionAction->execute($user, $validated);

        $photo = $validated["photo"];

        if ($photo) {
            $addImageToAuctionAction->execute($auction, $photo);
        }

        return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Aukcja została utworzona."]);
    }

    public function show(Auction $auction): Response
    {
        $auction->load(["category", "model.brand", "owner"]);

        return Inertia::render("Auction/ShowAuction", [
            "auction" => AuctionResource::make($auction)->resolve(),
        ]);
    }

    public function update(UpdateAuctionRequest $request, UpdateAuctionAction $updateAuctionAction, Auction $auction): RedirectResponse
    {
        if ($auction->owner->id !== auth()->id()) {
            return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Nie możesz edytować nie swoich aukcji"]);
        }

        $validated = $request->validated();
        $auction = $updateAuctionAction->execute($auction, $validated);

        return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Aukcja została edytowana."]);
    }

    public function finish(FinishAuctionAction $finishAuctionAction, Auction $auction): RedirectResponse
    {
        if ($auction->owner->id !== auth()->id()) {
            return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Nie możesz edytować nie swoich aukcji"]);
        }

        $auction = $finishAuctionAction->execute($auction);

        return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Aukcja została zakończona."]);
    }

    public function cancel(CancelAuctionAction $cancelAuctionAction, Auction $auction): RedirectResponse
    {
        if ($auction->owner->id !== auth()->id()) {
            return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Nie możesz edytować nie swoich aukcji"]);
        }

        $auction = $cancelAuctionAction->execute($auction);

        return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Aukcja została anulowana."]);
    }

    public function index(SortHelper $sorter, Request $request): Response
    {
        $auctions = Auction::query()->with(["category", "model.brand", "owner"])->where("auction_state", "=", AuctionState::ACTIVE);
        $categories = Category::query()->get();
        $models = CarModel::query()->with("brand")->get();
        $brands = Brand::query()->get();

        $perPage = (int)request()->query("per_page", 10);

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

    public function getImage(int $id, GetAuctionImageAction $getAuctionImageAction, GetDefaultAuctionImageAction $getDefaultAuctionImageAction): \Illuminate\Http\Response
    {
        $image = $getAuctionImageAction->execute($id);
        $default = $getDefaultAuctionImageAction->execute();

        return response($image ?? $default)
            ->header("Content-Type", "image/png")
            ->header("Cache-Control", "max-age=31536000, public");
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
        $brandId = $request->query("brand");

        if ($brandId === null) {
            return $query;
        }

        return $query->whereHas("model", function (Builder $q) use ($brandId): void {
            $q->where("brand_id", $brandId);
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
}
