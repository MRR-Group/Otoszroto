<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateBrandAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateBrandRequest;

class BrandController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateBrand", []);
    }

    public function store(CreateBrandRequest $request, CreateBrandAction $createBrandAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $createBrandAction->execute($validated);

        return $success
           ? redirect()->route("auction.brand.create")->with(["message" => "Brand has been created."])
           : redirect()->route("auction.brand.create")->with(["message" => "Invalid request."])->withInput();
    }
}
