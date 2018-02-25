<?php

namespace Lonebeta\DownloadAnalytics\Repositories;

use Lonebeta\DownloadAnalytics\Models\MetricType;
use Lonebeta\DownloadAnalytics\Models\Model;

/**
 * Class MetricTypeRepository
 * @package Lonebeta\DownloadAnalytics\Repositories
 */
class MetricTypeRepository extends Repository
{
    /**
     * @var Model
     */
    protected $model = MetricType::class;
}
