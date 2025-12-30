<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otoszroto\Models\Report;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        Report::factory()->count(30)->create();
    }
}
