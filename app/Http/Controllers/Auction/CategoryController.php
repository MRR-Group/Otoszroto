<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateCategoryRequest;
use Otoszroto\Models\Category;

class CategoryController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/Category", []);
    }

    public function store(CreateCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $category = new Category($validated);
        $category->save();

        return redirect()->route("home")->with(["message" => "Category has been created."]);
    }
}
