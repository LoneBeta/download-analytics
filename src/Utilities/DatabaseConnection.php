<?php

namespace Lonebeta\DownloadAnalytics\Utilities;

class DatabaseConnection
{
    public function __construct()
    {
        return new ConnectionFactory();
    }
}