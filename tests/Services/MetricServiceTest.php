<?php

namespace Lonebeta\DownloadAnalytics\Tests\Services;

use Lonebeta\DownloadAnalytics\Services\MetricService;
use PHPUnit\Framework\TestCase;

/**
 * Class MetricServiceTest
 * @package Lonebeta\DownloadAnalytics\Tests\Services
 */
class MetricServiceTest extends TestCase
{
    public function testGetMetrics()
    {
        /**
         * Set up mock data
         */
        $mockUnit       = json_decode('{"id":1}');
        $mockMetricType = json_decode('{"id":1}');

        /**
         * Set up mock objects
         */
        $metricRepository = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\MetricRepository');

        /**
         * Define mock methods within said object
         */
        $metricRepository->shouldReceive('getMetrics')->andReturn([]);

        /**
         * Get metrics from MetricService
         */
        $metricService = new MetricService($metricRepository);
        $metrics       = $metricService->getMetrics($mockUnit, $mockMetricType);

        $this->assertInternalType('array', $metrics);
    }
}
