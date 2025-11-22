<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateConditionRequest;
use Otoszroto\Models\Condition;

class ConditionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateCondition", []);
    }

    public function store(CreateConditionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $condition = new Condition($validated);
        $condition->save();

        return redirect()->route("home")->with(["message" => "Condition has been created."]);
    }
}
