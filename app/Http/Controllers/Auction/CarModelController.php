<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateCarModelRequest;
use Otoszroto\Models\CarModel;

class CarModelController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auction/CarModel", []);
    }

    public function store(CreateCarModelRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $car_model = new CarModel($validated);
        $car_model->save();

        return redirect()->route("home")->with(["message" => "Car model has been created."]);
    }
}
