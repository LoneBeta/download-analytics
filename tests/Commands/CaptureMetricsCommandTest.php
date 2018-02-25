<?php

namespace Lonebeta\DownloadAnalytics\Tests\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Lonebeta\DownloadAnalytics\Commands\CaptureMetricsCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class CaptureMetricsCommandTest
 * @package Lonebeta\DownloadAnalytics\Tests\Commands
 */
class CaptureMetricsCommandTest extends TestCase
{
    public function testHandle()
    {
        /**
         * Setup MockHandler for Guzzle Client
         */
        $mockHandler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'])
        ]);

        /**
         * Set environment variable for json host
         */
        putenv('JSON_HOST=/');

        /**
         * Set up mock objects
         */
        $captureMetricService = \Mockery::mock('Lonebeta\\DownloadAnalytics\\Services\\CaptureMetricService');
        $client               = new Client(['handler' => HandlerStack::create($mockHandler)]);

        /**
         * Define mock methods within said objects
         */
        $captureMetricService->shouldReceive('execute')->andReturn('true');

        /**
         * Execute handle method for CaptureMetricsCommand
         */
        $captureMetricsCommand = new CaptureMetricsCommand($captureMetricService, $client);
        $result                = $captureMetricsCommand->handle();

        $this->assertTrue($result);
    }
}
