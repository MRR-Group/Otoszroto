<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Auction;
use Otoszroto\Models\Report;
use Otoszroto\Models\User;

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
