<?php

// $start = microtime(true);
// $startMem = memory_get_usage();

require '../core/Router.php';

$router = new Router;
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];
require '../views/routes.php';

$router->route($uri, $method);

// $end = microtime(true);
// $endMem = memory_get_usage();

// echo "Time: " . ($end - $start) . " seconds\n";
// echo "Memory: " . ($endMem - $startMem) . " bytes\n";
