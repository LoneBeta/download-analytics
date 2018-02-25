<?php

namespace Lonebeta\DownloadAnalytics\Tests\Services;

use Lonebeta\DownloadAnalytics\Services\CaptureMetricService;
use PHPUnit\Framework\TestCase;

/**
 * Class CaptureMetricServiceTest
 * @package Lonebeta\DownloadAnalytics\Tests\Services
 */
class CaptureMetricServiceTest extends TestCase
{
    public function testExecute()
    {
        /**
         * Set up mock data
         */
        $mockData       = json_decode('[{"unit_id": 1,"metrics": {"download": [{"timestamp": "2017-02-09 19:00:00","value": 4669200}]}}]');
        $mockUnit       = json_decode('{"id":1}');
        $mockMetricType = json_decode('{"id":1}');

        /**
         * Set up mock objects
         */
        $metricRepository     = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\MetricRepository');
        $metricTypeRepository = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\MetricTypeRepository');
        $unitRepository       = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\UnitRepository');

        /**
         * Define mock methods within said object
         */
        $unitRepository->shouldReceive('firstOrCreate')->andReturn($mockUnit);
        $metricTypeRepository->shouldReceive('firstOrCreate')->andReturn($mockMetricType);
        $metricRepository->shouldReceive('insertOnDuplicateKey')->andReturn(true);

        /**
         * Execute CaptureMetricService
         */
        $captureMetricService = new CaptureMetricService($metricRepository, $metricTypeRepository, $unitRepository);
        $result               = $captureMetricService->execute($mockData);

        $this->assertEquals(true, $result);
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
