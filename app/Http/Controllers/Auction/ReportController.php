<?php

declare(strict_types=1);

namespace Otoszroto\Http\Controllers\Auction;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Otoszroto\Actions\Auction\CreateReportAction;
use Otoszroto\Helpers\SortHelper;
use Otoszroto\Http\Controllers\Controller;
use Otoszroto\Http\Requests\Auction\CreateReportRequest;
use Otoszroto\Http\Resources\ReportResource;
use Otoszroto\Models\Auction;
use Otoszroto\Models\Report;

class ReportController extends Controller
{
    public function create(Auction $auction): Response
    {
        return Inertia::render("Auction/ReportAuction", ["auction" => $auction]);
    }

    public function store(CreateReportRequest $request, CreateReportAction $createReportAction, Auction $auction): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $createReportAction->execute($user, $auction, $validated);

        return redirect()->route("auctions.show", ["auction" => $auction])->with(["message" => "Aukcja została zgłoszona."]);
    }

    public function index(SortHelper $sorter): Response
    {
        $reports = Report::query()->with(["reporter", "auction"])->where("resolved_at", "=", null);

        $perPage = (int)request()->query("per_page", 10);

        $query = $sorter->sort($reports, ["id", "created_at"], []);
        $query = $sorter->search($query, "id");

        return Inertia::render("Auction/Reports", [
            "reports" => ReportResource::collection($query->paginate($perPage)),
        ]);
    }

    public function show(Report $report): Response
    {
        $report->load(["reporter", "auction"]);

        return Inertia::render("Auction/ShowReport", [
            "report" => new ReportResource($report),
        ]);
    }
}
