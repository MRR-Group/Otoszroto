<?php

declare(strict_types=1);

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class UsersLineChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = "line";

    protected $height = 250;

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
