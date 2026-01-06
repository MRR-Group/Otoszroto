<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auction;

use App\Actions\Auction\CreateReportAction;
use App\Actions\Auction\ResolveReportAction;
use App\Helpers\SortHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auction\CreateReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Auction;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function create(Auction $auction): Response
    {
        return Inertia::render("Auction/ReportAuction", ["auction" => $auction]);
    }

    public function store(CreateReportRequest $request, CreateReportAction $createReportAction, Auction $auction): RedirectResponse
    {
        $user = $request->user();
        $this->authorize("report", $auction);
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

    public function resolve(ResolveReportAction $resolveReportAction, Report $report): RedirectResponse
    {
        $report = $resolveReportAction->execute($report);

        return redirect()->route("reports.show", ["report" => $report])->with(["message" => "Zgłoszenie zostało rozwiązane."]);
    }
}
