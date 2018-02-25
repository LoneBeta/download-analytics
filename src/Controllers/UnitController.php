<?php

namespace Lonebeta\DownloadAnalytics\Controllers;

use Lonebeta\DownloadAnalytics\Services\MetricService;

class UnitController
{
    public function __construct(MetricService $metricService)
    {
        $this->metricService = $metricService;
    }

    public function view($unitId, $metricTypeName)
    {
        return ['data' => []];
    }
}