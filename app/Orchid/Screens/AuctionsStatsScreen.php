<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\AuctionsLineChart;
use Carbon\Carbon;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Otoszroto\Models\Auction;

class AuctionsStatsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {$start = Carbon::now()->subDays(6)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        $auctionsTotal = Auction::count();
        $auctionsToday = Auction::whereDate('created_at', Carbon::today())->count();

        $byStatus = Auction::query()
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->orderByDesc('c')
            ->get()
            ->map(fn($row) => ['status' => $row->status, 'count' => (int)$row->c]);

        return [
            'auctionMetrics' => [
                'total' => $auctionsTotal,
                'today' => $auctionsToday,
            ],

            'auctionsSeries' => [
                Auction::countByDays($start, $end)->toChart('Aukcje'),
            ],

            'auctionsByStatus' => $byStatus,

            'latestAuctions' => Auction::query()
                ->orderByDesc('id')
                ->limit(10)
                ->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'AuctionsStatsScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Aukcje (łącznie)' => 'auctionMetrics.total',
                'Aukcje dziś'      => 'auctionMetrics.today',
            ]),

            AuctionsLineChart::make('auctionsSeries', 'Nowe aukcje (ostatnie 7 dni)')
                ->description('Liczba utworzonych aukcji dziennie'),

            Layout::table('latestAuctions', [
                TD::make('id', 'ID'),
                TD::make('title', 'Tytuł'),
                TD::make('status', 'Status'),
                TD::make('created_at', 'Utworzono'),
            ])->title('Ostatnio dodane aukcje'),
        ];
    }
}
