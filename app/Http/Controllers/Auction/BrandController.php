<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateBrandRequest;
use Otoszroto\Models\Brand;

class BrandController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/Brand", []);
    }

    public function store(CreateBrandRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $brand = new Brand($validated);
        $brand->save();

        return redirect()->route("home")->with(["message" => "Brand has been created."]);
    }
}
