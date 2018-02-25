<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';

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

/**
 * @param \FastRoute\Dispatcher $dispatcher
 * @param $container
 * @return mixed
 */
function handleRequest(\FastRoute\Dispatcher $dispatcher, $container)
{
    $routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

    if($routeInfo[0] == 0){
       die("Route not found!");
    }

    $handler    = parseHandler($routeInfo[1]);
    $arguments  = $routeInfo[2];
    $controller = $container->get('Lonebeta\\DownloadAnalytics\\Controllers\\' . $handler['class']);

    return call_user_func_array( [$controller, $handler['method']], $arguments);
}

/**
 * @param $handler
 * @return array
 */
function parseHandler($handler)
{
    $handler = explode("@", $handler);

    return ['class' => $handler[0], 'method' => $handler[1]];
}
