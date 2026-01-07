<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Seller;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Helpers\SortHelper;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Resources\AuctionResource;
use Otoszroto\Http\Resources\BrandResource;
use Otoszroto\Http\Resources\CategoryResource;
use Otoszroto\Http\Resources\ModelResource;
use Otoszroto\Models\Auction;
use Otoszroto\Models\Brand;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Category;

class SellerController extends Controller
{
    public function index(SortHelper $sorter, Request $request): Response
    {
        $auctions = Auction::query()->with(["category", "model.brand", "owner"])->where("owner_id", "=", auth()->id());
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
        $query = $this->filterStatus($query, $request);
        $query = $this->filterPriceMin($query, $request);
        $query = $this->filterPriceMax($query, $request);

        return Inertia::render("Auction/Seller", [
            "auctions" => AuctionResource::collection($query->paginate($perPage)),
            "categories" => CategoryResource::collection($categories)->resolve(),
            "models" => ModelResource::collection($models)->resolve(),
            "brands" => BrandResource::collection($brands)->resolve(),
        ]);
    }

    private function filterStatus(Builder $query, Request $request): Builder
    {
        $state = $request->query("status", null);

        if ($state === null) {
            return $query;
        }

        return $query->where(fn(Builder $query) => $query->where("auction_state", "=", $state));
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
