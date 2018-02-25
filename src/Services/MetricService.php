<?php

namespace Lonebeta\DownloadAnalytics\Services;

use Lonebeta\DownloadAnalytics\Repositories\MetricRepository;
use Lonebeta\DownloadAnalytics\Utilities\DatabaseConnection;

/**
 * Class MetricService
 * @package Lonebeta\DownloadAnalytics\Services
 */
class MetricService
{
    /**
     * MetricService constructor.
     * @param MetricRepository $metricRepository
     */
    public function __construct(MetricRepository $metricRepository)
    {
        $this->metricRepository = $metricRepository;
    }

    /**
     * @param \stdClass $unit
     * @param \stdClass $metricType
     * @return array
     */
    public function getMetrics(\stdClass $unit, \stdClass $metricType): array
    {
        return $this->metricRepository->getMetrics($unit->id, $metricType->id);
    }
}
