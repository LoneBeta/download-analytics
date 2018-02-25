<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';

use \Lonebeta\DownloadAnalytics\Utilities\JsonResponse;

/**
 * Load .env file into global environment variables
 */
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/**
 * Create DI Container
 */
$container = new \DI\Container();

if (isset($_SERVER['REQUEST_METHOD'])) {
    handleRequest($dispatcher, $container);
}

function handleRequest(\FastRoute\Dispatcher $dispatcher, $container)
{
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri        = $_SERVER['REQUEST_URI'];
    $routeInfo  = $dispatcher->dispatch($httpMethod, $uri);

    $handler   = parseHandler($routeInfo[1]);
    $arguments = $routeInfo[2];

    $controller = $container->get($handler['class']);

    return $controller->$handler['method'](...$arguments);
}

function parseHandler($handler)
{
    $handler = explode("@", $handler);

    return ['class' => $handler[0], 'method' => $handler[1]];
}
