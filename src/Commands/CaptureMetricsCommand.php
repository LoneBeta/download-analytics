<?php

namespace Lonebeta\DownloadAnalytics\Commands;

use GuzzleHttp\Client;
use Lonebeta\DownloadAnalytics\Services\CaptureMetricService;

/**
 * Class CaptureMetricsCommand
 * @package Lonebeta\DownloadAnalytics\Commands
 */
class CaptureMetricsCommand
{
    /**
     * @var CaptureMetricService
     */
    protected $captureMetricService;

    /**
     * @var Client
     */
    protected $client;

    /**
     * CaptureMetricsCommand constructor.
     * @param CaptureMetricService $captureMetricService
     * @param Client $client
     */
    public function __construct(CaptureMetricService $captureMetricService, Client $client)
    {
        $this->captureMetricService = $captureMetricService;
        $this->client               = $client;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $this->captureMetricService->execute($this->getMetrics());

        return true;
    }

    /**
     * I am simply calling data from the main API/URL provided but for large data sets, we'd probably be pulling
     * from some sort of queuing system i.e. RabbitMQ or Kafka
     *
     * @return array
     */
    protected function getMetrics(): array
    {
        $metrics = $this->client->get(getenv('JSON_HOST'));

        if($metrics = $metrics->getBody()->getContents()){
            return json_decode($metrics);
        }
        return [];
    }
}
