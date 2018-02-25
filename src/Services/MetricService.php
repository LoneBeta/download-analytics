<?php

namespace Lonebeta\DownloadAnalytics\Services;

use Lonebeta\DownloadAnalytics\Utilities\DatabaseConnection;

class MetricService
{
    /**
     * MetricService constructor.
     * @param DatabaseConnection $connection
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param \stdClass $unit
     * @param \stdClass $metricType
     * @return mixed
     */
    public function getMetrics(\stdClass $unit, \stdClass $metricType)
    {
        return Metric::where('unit_id', $unit->id)
            ->where('type', $metricType->id)
            ->selectRaw(implode(',', $this->rawSelect))
            ->groupBy(DB::raw('DATE_FORMAT(timestamp, "%Y-%m-%d %H:00:00")'))
            ->get()
            ->toArray();
    }

    protected $sql = 'SELECT DATE_FORMAT(timestamp, "%Y-%m-%d %H:00:00") as timestamp,
        avg(value) as average, min(value) as minimum,
        max(value) as maximum, (min(value) + max(value) / count(value)) as median,
        count(value) as sample_size
        FROM metrics
        WHERE unit_id = :unitId
        AND type = :type
        GROUP BY DATE_FORMAT(timestamp, "%Y-%m-%d %H:00:00")';
}