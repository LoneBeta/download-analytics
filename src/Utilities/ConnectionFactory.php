<?php

namespace Lonebeta\DownloadAnalytics\Utilities;

class ConnectionFactory
{
    protected static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            $host     = getenv('DB_HOST');
            $database = getenv('DB_DATABASE');
            $port     = getenv('DB_PORT');
            $username = getenv('DB_USERNAME');
            $password = getenv('DB_PASSWORD');

            self::$connection = new \PDO("mysql:host=$host:$port;dbname=$database",$username,$password);
        }
        return self::$connection;
    }
}
