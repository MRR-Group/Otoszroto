<?php

declare(strict_types=1);

namespace Otoszroto\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /** @var string */
    protected $rootView = "app";

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            "appName" => fn() => config("app.name"),
            "flash" => $this->getFlashData($request),
            "user" => $request->user(),
        ]);
    }

    protected function getFlashData(Request $request): Closure
    {
        return fn(): array => [
            'message' => fn () => $request->session()->get('message'),
            "error" => $request->session()->get("error"),
            "status" => $request->session()->get("status"),
        ];
    }
}
