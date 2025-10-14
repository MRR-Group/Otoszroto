<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auth\RegisterRequest;
use Otoszroto\Models\User;

class RegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render("Auth/Register", []);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = new User($validated);
        $user->password = Hash::make($validated["password"]);
        $user->save();

        return redirect()->route("home");
    }
}
