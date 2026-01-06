<?php

declare(strict_types=1);

namespace App\Actions\Auction;

use App\Models\Report;

class ResolveReportAction
{
    public function execute(Report $report): Report
    {
        $report->resolved_at = now();
        $report->save();

        return $report;
    }
}
