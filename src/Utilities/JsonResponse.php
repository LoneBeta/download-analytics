<?php

namespace Lonebeta\DownloadAnalytics\Utilities;

/**
 * Basic class for converting content to JSON and setting appropriate mime type
 *
 * Class JsonResponse
 * @package Lonebeta\DownloadAnalytics\Utilities
 */
class JsonResponse
{
    /**
     * JsonResponse constructor.
     * @param $data
     */
    public function __construct($data)
    {
        header('Content-Type: application/json');

        echo json_encode($data);

        return true;
    }
}
