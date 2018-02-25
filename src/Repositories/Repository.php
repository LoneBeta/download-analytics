<?php

namespace Lonebeta\DownloadAnalytics\Repositories;

use Lonebeta\DownloadAnalytics\Models\Model;
use Lonebeta\DownloadAnalytics\Utilities\DatabaseConnection;

/**
 * Class Repository
 * @package Lonebeta\DownloadAnalytics\Repositories
 */
abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * This model takes the method request from the repository and passes it over to the model.
     *
     * This allows us to keep our logic attached to our model while keeping a layer of abstraction to aid testing.
     *
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->model, $method)) {
            $model = new $this->model($this->connection);

            return call_user_func_array([$model, $method], $parameters);
        }
        throw new \Exception('Method $method does not exist on class $this->model');
    }
}
