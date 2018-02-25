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
        $this->connection = $connection;
    }

    /**
     * @param array $findBy
     * @param array $columnsAndValues
     */
    public function firstOrCreate(array $findBy, array $columnsAndValues)
    {

    }

    /**
     * @param array $columnsAndValues
     */
    public function create(array $columnsAndValues)
    {

    }

    /**
     * @param array $columnsAndValues
     */
    public function findBy(array $columnsAndValues)
    {

    }

    /**
     * @param array $columnsAndValues
     */
    public function insertOnDuplicateKey(array $columnsAndValues)
    {

    }
}
