<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{

    public function create(): \Inertia\Response
    {
        return Inertia::render("Auth/Login", []);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $key = 'login:'.strtolower($request->input('email')).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'message' => __("Too many attempts. Try again in :seconds seconds.", ['seconds' => $seconds]),
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'message' => __('These credentials do not match our records.'),
            ])->status(Response::HTTP_FORBIDDEN);
        }


        $request->session()->regenerate();

        return redirect()->route("home");
    }
}
