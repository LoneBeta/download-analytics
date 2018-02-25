<?php

require_once __DIR__.'/../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/unit/{unit}/{metricType}', 'UnitController@view');
});
