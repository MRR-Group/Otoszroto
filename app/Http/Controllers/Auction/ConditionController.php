<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateConditionAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateConditionRequest;

class ConditionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateCondition", []);
    }

    public function store(CreateConditionRequest $request, CreateConditionAction $createConditionAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $createConditionAction->execute($validated);

        return $success
            ? redirect()->route("auction.condition.create")->with(["message" => "Condition has been created."])
            : redirect()->route("auction.condition.create")->with(["message" => "Invalid request."])->withInput();
    }
}
