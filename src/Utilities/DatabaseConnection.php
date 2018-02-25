<?php

namespace Lonebeta\DownloadAnalytics\Utilities;

class DatabaseConnection
{
    public function __construct()
    {
        $this->connection = ConnectionFactory::getConnection();
    }
}