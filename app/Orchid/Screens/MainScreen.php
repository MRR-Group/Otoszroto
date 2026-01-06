<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\UsersLineChart;
use Carbon\Carbon;
use Orchid\Screen\TD;
use App\Models\User;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class MainScreen extends Screen
{
    public function name(): ?string
    {
        return 'Statystyki';
    }

    public function query(): iterable
    {
        $today = Carbon::today()->endOfDay();
        $weekAgo = Carbon::now()->subDays(6)->startOfDay();

        $usersTotal = User::count();
        $usersToday = User::whereDate('created_at', $today)->count();

        $usersLast7Days = User::query()
            ->selectRaw("DATE(created_at) as day, COUNT(*) as count")
            ->where('created_at', '>=', $weekAgo)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $series = [];
        for ($i = 0; $i < 7; $i++) {
            $d = $weekAgo->copy()->addDays($i)->toDateString();
            $series[] = [
                'day' => $d,
                'count' => (int)($usersLast7Days[$d]->count ?? 0),
            ];
        }

        return [
            'metrics' => [
                'usersTotal' => $usersTotal,
                'usersToday' => $usersToday,
            ],

            'usersSeries' => $series,

            'members' => [
                User::countByDays($weekAgo, $today)->toChart('Users'),
            ],

            'latestUsers' => User::query()->orderByDesc('id')->limit(10)->get(),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Użytkownicy (łącznie)' => 'metrics.usersTotal',
                'Nowi dziś' => 'metrics.usersToday',
            ]),

            UsersLineChart::make('members', 'Nowi użytkownicy (ostatnie 7 dni)')
                ->description('Liczba rejestracji dziennie'),

            Layout::table('latestUsers', [
                TD::make('id', 'ID'),
                TD::make('name', 'Nazwa'),
                TD::make('email', 'Email'),
                TD::make('created_at', 'Utworzono'),
            ])->title('Ostatnio dodani użytkownicy'),
        ];
    }
}
