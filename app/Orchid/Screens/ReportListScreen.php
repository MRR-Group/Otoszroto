<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ReportListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Raporty';
    }

    public function description(): ?string
    {
        return 'Zgłoszenia aukcji – przegląd i szybkie akcje moderacji.';
    }

    public function query(Request $request): iterable
    {
        $only = $request->get('only');

        $q = Report::query()
            ->with(['reporter', 'auction'])
            ->orderByDesc('id');

        if ($only === 'open') {
            $q->whereNull('resolved_at');
        } elseif ($only === 'resolved') {
            $q->whereNotNull('resolved_at');
        }

        return [
            'reports' => $q->paginate(25),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Wszystkie')
                ->route('platform.reports'),

            Link::make('Tylko otwarte')
                ->route('platform.reports', ['only' => 'open'])
                ->icon('bs.exclamation-circle'),

            Link::make('Tylko rozwiązane')
                ->route('platform.reports', ['only' => 'resolved'])
                ->icon('bs.check2-circle'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('reports', [
                TD::make('id', 'Zgłoszenie')
                    ->sort()
                    ->render(fn (Report $r) => $r->id),

                TD::make('auction', 'Aukcja')
                    ->render(function (Report $r) {
                        $title = $r->auction?->title ?? ('#'.$r->auction_id);
                        return e($title);
                    }),

                TD::make('reporter', 'Zgłaszający')
                    ->render(fn (Report $r) => $r->reporter?->email ?? ('#'.$r->reporter_id)),

                TD::make('reason', 'Powód')
                    ->render(fn (Report $r) => e($r->reason ?? '—')),

                TD::make('status', 'Status')
                    ->render(fn (Report $r) => $r->resolved_at ? '✅ rozwiązany' : '⏳ otwarty'),

                TD::make('created_at', 'Utworzono')
                    ->sort()
                    ->render(fn (Report $r) => optional($r->created_at)->format('Y-m-d H:i')),

                TD::make('Akcje')
                    ->align(TD::ALIGN_RIGHT)
                    ->render(function (Report $r) {
                        return
                            Button::make($r->resolved_at ? 'Cofnij' : 'Rozwiąż')
                                ->icon($r->resolved_at ? 'bs.arrow-counterclockwise' : 'bs.check2')
                                ->method('toggleResolved')
                                ->parameters(['report_id' => $r->id])
                                ->render()

                            .' '.

                            Button::make('Usuń aukcję')
                                ->icon('bs.trash')
                                ->confirm('Na pewno usunąć zgłoszoną aukcję? To usunie rekord aukcji (i ewentualnie powiązane dane zależnie od relacji).')
                                ->method('deleteAuction')
                                ->parameters(['report_id' => $r->id])
                                ->render()

                            .' '.

                            Button::make('Usuń zgłaszającego')
                                ->icon('bs.person-x')
                                ->confirm('Na pewno usunąć użytkownika zgłaszającego? (opcjonalnie można też usunąć jego raporty)')
                                ->method('deleteReporter')
                                ->parameters(['report_id' => $r->id])
                                ->render();
                    }),
            ]),
        ];
    }

    public function toggleResolved(Request $request): void
    {
        $reportId = (int) $request->get('report_id');

        Report::query()
            ->whereKey($reportId)
            ->update([
                'resolved_at' => DB::raw('CASE WHEN resolved_at IS NULL THEN NOW() ELSE NULL END'),
            ]);
    }

    public function deleteAuction(Request $request): void
    {
        $reportId = (int) $request->get('report_id');

        $report = Report::query()
            ->with('auction')
            ->findOrFail($reportId);

        if ($report->auction) {
            $report->auction->delete();
        }

        $report->resolved_at = now();
        $report->save();
    }

    public function deleteReporter(Request $request): void
    {
        $reportId = (int) $request->get('report_id');

        $report = Report::query()
            ->with('reporter')
            ->findOrFail($reportId);

        if (! $report->reporter) {
            return;
        }

        $reporter = $report->reporter;

        Report::query()->where('reporter_id', $reporter->id)->delete();

        $reporter->delete();
    }
}
