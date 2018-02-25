<?php

namespace Lonebeta\DownloadAnalytics\Controllers;

use Lonebeta\DownloadAnalytics\Repositories\MetricTypeRepository;
use Lonebeta\DownloadAnalytics\Repositories\UnitRepository;
use Lonebeta\DownloadAnalytics\Services\MetricService;
use Lonebeta\DownloadAnalytics\Utilities\JsonResponse;

/**
 * Class UnitController
 * @package Lonebeta\DownloadAnalytics\Controllers
 */
class UnitController
{
    /**
     * UnitController constructor.
     * @param MetricService $metricService
     * @param UnitRepository $unitRepository
     * @param MetricTypeRepository $metricTypeRepository
     */
    public function __construct(
        MetricService $metricService,
        UnitRepository $unitRepository,
        MetricTypeRepository $metricTypeRepository
    )
    {
        $this->metricService        = $metricService;
        $this->unitRepository       = $unitRepository;
        $this->metricTypeRepository = $metricTypeRepository;
    }

    /**
     * @param $unitId
     * @param $metricTypeName
     * @return JsonResponse
     */
    public function view($unitId, $metricTypeName)
    {
        $unit       = $this->unitRepository->findBy('id', $unitId);
        $metricType = $this->metricTypeRepository->findBy('name', $metricTypeName);

        $data = $this->metricService->getMetrics($unit, $metricType);

        return new JsonResponse(['data' => $data]);
    }
}
