<?php

namespace Lonebeta\DownloadAnalytics\Repositories;

use Lonebeta\DownloadAnalytics\Models\Metric;
use Lonebeta\DownloadAnalytics\Models\Model;

/**
 * Class MetricRepository
 * @package Lonebeta\DownloadAnalytics\Repositories
 */
class MetricRepository extends Repository
{
    /**
     * @var Model
     */
    protected $model = Metric::class;

    /**
     * @param int $unitId
     * @param int $metricTypeId
     * @return array
     */
    public function getMetrics(int $unitId, int $metricTypeId)
    {
        $query = $this->connection->connection->prepare($this->metricSql);
        $query->execute(['unitId' => $unitId, 'type' => $metricTypeId]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @var string
     */
    protected $metricSql = 'SELECT DATE_FORMAT(timestamp, "%Y-%m-%d 00:00:00") as timestamp,
        avg(value) as average, min(value) as minimum,
        max(value) as maximum, (min(value) + max(value) / count(value)) as median,
        count(value) as sample_size
        FROM metrics
        WHERE unit_id = :unitId
        AND type = :type
        GROUP BY DATE_FORMAT(timestamp, "%Y-%m-%d 00:00:00")';
}
