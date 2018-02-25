<?php

namespace Lonebeta\DownloadAnalytics\Tests\Controllers;

use Lonebeta\DownloadAnalytics\Controllers\UnitController;
use Lonebeta\DownloadAnalytics\Models\Unit;
use PHPUnit\Framework\TestCase;

/**
 * Class UnitControllerTest
 * @package Lonebeta\DownloadAnalytics\Tests\Controllers
 */
class UnitControllerTest extends TestCase
{
    public function testView()
    {
        /**
         * Set up mock data
         */
        $mockUnit       = json_decode('{"id":1}');
        $mockMetricType = json_decode('{"id":1}');

        /**
         * Set up mock objects
         */
        $metricTypeRepository = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\MetricTypeRepository');
        $unitRepository       = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Repositories\\UnitRepository');
        $metricService        = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Services\\MetricService');

        /**
         * Define mock methods within said object
         */
        $unitRepository->shouldReceive('findBy')->andReturn($mockUnit);
        $metricTypeRepository->shouldReceive('findBy')->andReturn($mockMetricType);
        $metricService->shouldReceive('getMetrics')->andReturn([]);

        /**
         * Execute view method of UnitController
         */
        $unitController = new UnitController($metricService,$unitRepository,$metricTypeRepository);
        $result = $unitController->view(1,'download');

        $this->assertTrue($result);
    }
}
