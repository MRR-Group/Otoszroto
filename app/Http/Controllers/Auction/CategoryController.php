<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateCategoryAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateCategoryRequest;

class CategoryController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateCategory", []);
    }

    public function store(CreateCategoryRequest $request, CreateCategoryAction $createCategoryAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $createCategoryAction->execute($validated);

        return $success
            ? redirect()->route("auction.category.create")->with(["message" => "Category has been created."])
            : redirect()->route("auction.category.create")->with(["message" => "Invalid request."])->withInput();
    }
}
