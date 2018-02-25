<?php

namespace Lonebeta\DownloadAnalytics\Repositories;

use Lonebeta\DownloadAnalytics\Models\Model;
use Lonebeta\DownloadAnalytics\Models\Unit;

/**
 * Class UnitRepository
 * @package Lonebeta\DownloadAnalytics\Repositories
 */
class UnitRepository extends Repository
{
    /**
     * @var Model
     */
    protected $model = Unit::class;
}
