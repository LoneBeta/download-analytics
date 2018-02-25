<?php

namespace Lonebeta\DownloadAnalytics\Services;

use Lonebeta\DownloadAnalytics\Repositories\MetricRepository;
use Lonebeta\DownloadAnalytics\Repositories\MetricTypeRepository;
use Lonebeta\DownloadAnalytics\Repositories\UnitRepository;

/**
 * Class CaptureMetricService
 * @package Lonebeta\DownloadAnalytics\Services
 */
class CaptureMetricService
{
    /**
     * @var MetricRepository
     */
    protected $metricRepository;

    /**
     * @var MetricTypeRepository
     */
    protected $metricTypeRepository;

    /**
     * @var UnitRepository
     */
    protected $unitRepository;

    /**
     * CaptureMetricService constructor.
     *
     * @param MetricRepository $metricRepository
     * @param MetricTypeRepository $metricTypeRepository
     * @param UnitRepository $unitRepository
     */
    public function __construct(
        MetricRepository $metricRepository,
        MetricTypeRepository $metricTypeRepository,
        UnitRepository $unitRepository
    )
    {
        $this->metricRepository     = $metricRepository;
        $this->metricTypeRepository = $metricTypeRepository;
        $this->unitRepository       = $unitRepository;
    }

    /**
     * @param $units
     * @return bool
     */
    public function execute($units): bool
    {
        foreach ($this->processUnits($units) as $metrics) {
            $this->insertMetricsIntoDatabase($metrics);
        }
        return true;
    }

    /**
     * @param array $units
     * @return \Generator
     */
    protected function processUnits(array $units): \Generator
    {
        foreach ($units as $unit) {
            yield from $this->processUnit($unit);
        }
    }

    /**
     * Returning a generator here will allow us to pass data up the chain/insert into the database as the data is ready.
     *
     * Data being passed up is per unit/device.
     *
     * This reduces memory consumption.
     *
     * @param $unit
     * @return \Generator
     */
    protected function processUnit(\stdClass $unit): \Generator
    {
        $unitMetrics = $unit->metrics;
        $unit        = $this->getUnitFromDB($unit->unit_id);

        foreach ($unitMetrics as $metricName => $metrics) {
            $metricType = $this->getMetricTypeFromDB($metricName);
            yield $this->processUnitMetrics($unit->id, $metricType, $metrics);
        }
    }

    /**
     * @param int $unitId
     * @param \stdClass $metricType
     * @param array $metrics
     * @return array
     */
    protected function processUnitMetrics(int $unitId, \stdClass $metricType, array $metrics): array
    {
        $returnMetrics = [];

        foreach ($metrics as $metric) {
            $returnMetrics[] = [
                "unit_id"   => $unitId,
                "type"      => $metricType->id,
                "value"     => $metric->value,
                "timestamp" => $metric->timestamp
            ];
        }
        return $returnMetrics;
    }

    /**
     * If data for your units/boxes is only fetched/inserted once, then insert would suffice.
     *
     * But for the purpose of backfilling metrics in the future, "insertOnDuplicateKeyUpdate" allows us to use the same code.
     *
     * @param $metrics
     */
    protected function insertMetricsIntoDatabase($metrics): void
    {
        $this->metricRepository->insertOnDuplicateKey($metrics);
    }

    /**
     * Units probably wouldn't be created or updated at this stage.
     *
     * I have only added this in for the purpose of demonstration.
     *
     * @param int $unitId
     * @return \stdClass
     */
    protected function getUnitFromDB(int $unitId): \stdClass
    {
        return $this->unitRepository->firstOrCreate(
            ['id' => $unitId],
            [
                'provider' => 'Virgin Media',
                'model'    => 1234
            ]);
    }

    /**
     * @param string $metricTypeName
     * @return \stdClass
     */
    protected function getMetricTypeFromDB(string $metricTypeName): \stdClass
    {
        return $this->metricTypeRepository->firstOrCreate(['name' => $metricTypeName]);
    }
}
