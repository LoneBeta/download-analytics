<?php

namespace Lonebeta\DownloadAnalytics\Controllers;

use function DI\value;
use Lonebeta\DownloadAnalytics\Models\MetricType;
use Lonebeta\DownloadAnalytics\Models\Unit;
use Lonebeta\DownloadAnalytics\Services\MetricService;
use Lonebeta\DownloadAnalytics\Utilities\DatabaseConnection;
use Lonebeta\DownloadAnalytics\Utilities\JsonResponse;

class UnitController
{
    public function __construct(MetricService $metricService, DatabaseConnection $connection)
    {
        $this->metricService = $metricService;
        $this->connection = $connection;
    }

    public function view($unitId, $metricTypeName)
    {
        $unit       = (new Unit($this->connection))->findBy('id', $unitId);
        $metricType = (new MetricType($this->connection))->findBy('name', $metricTypeName);

        $data = $this->metricService->getMetrics($unit, $metricType);

        return new JsonResponse(['data' => $data]);
    }
}
