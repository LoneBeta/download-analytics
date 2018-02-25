<?php

namespace Lonebeta\DownloadAnalytics\Models;

use Lonebeta\DownloadAnalytics\Utilities\DatabaseConnection;

abstract class Model
{
    /**
     * The inheriting models table name
     *
     * @var string
     */
    protected $table;

    /**
     * @var DatabaseConnection
     */
    protected $connection;

    /**
     * Model constructor.
     * @param DatabaseConnection $connection
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection->connection;
    }

    /**
     * @param array $findBy
     * @param array $columnsAndValues
     * @return mixed
     */
    public function firstOrCreate(array $findBy, array $columnsAndValues = [])
    {
        $record = $this->findBy(array_keys($findBy)[0], $findBy);

        if (!$record) {
            $record = $this->create(array_merge($findBy, $columnsAndValues));
        }
        return $record;
    }

    /**
     * @param array $columnsAndValues
     * @return mixed
     */
    public function create(array $columnsAndValues)
    {
        $columns = $this->prepareColumns($columnsAndValues);
        $values  = $this->prepareValues($columnsAndValues);

        $sql   = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $query = $this->connection->prepare($sql);

        return $query->execute(array_values($columnsAndValues));
    }

    /**
     * @param $columnsAndValues
     * @return string
     */
    protected function prepareColumns($columnsAndValues)
    {
        return implode(",", array_keys($columnsAndValues));
    }

    /**
     * @param $columnsAndValues
     * @return array
     */
    protected function prepareValues($columnsAndValues)
    {
        return array_values(array_map(function ($values) {
            return "?";
        }, $columnsAndValues));
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findBy($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = ?";

        $query = $this->connection->prepare($sql);
        $query->execute(array_values($value));

        return $query->fetch();
    }

    /**
     * @param array $columnsAndValues
     */
    public function insertOnDuplicateKey(array $columnsAndValues)
    {
        $preparedValues = [];
        $columns        = $this->prepareColumns($columnsAndValues[0]);

        $sql = "INSERT INTO $this->table ($columns) VALUES ";

        foreach ($columnsAndValues as $values) {
            $preparedValues[] = "(" . $this->prepareValues($values) . ")";
        }
        $sql .= implode(',', $preparedValues);

        var_dump($sql);
        die;
    }
}
