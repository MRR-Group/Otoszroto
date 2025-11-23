<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateCarModelAction;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateCarModelRequest;

class CarModelController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CreateCarModel", []);
    }

    public function store(CreateCarModelRequest $request, CreateCarModelAction $createCarModelAction): RedirectResponse
    {
        $validated = $request->validated();
        $success = $createCarModelAction->execute($validated);

        return $success
            ? redirect()->route("auction.model.create")->with(["message" => "Car model has been created."])
            : redirect()->route("auction.model.create")->with(["message" => "Invalid request."])->withInput();
    }
}
