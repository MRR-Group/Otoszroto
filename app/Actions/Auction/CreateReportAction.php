<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Models\Auction;
use App\Models\Report;
use App\Models\User;

class CreateReportAction
{
    public function execute(User $user, Auction $auction, array $reportData): Report
    {
        $report = new Report($reportData);
        $report->reporter->associate($user);
        $report->auction->associate($auction);
        $report->save();

        return $report;
    }
}
