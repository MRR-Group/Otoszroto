<?php

declare(strict_types=1);

namespace Otoszroto\Actions\Auction;

use Otoszroto\Models\Report;

class ResolveReportAction
{
    public function execute(Report $report): Report
    {
        $report->resolved_at = now();
        $report->save();

        return $report;
    }
}
