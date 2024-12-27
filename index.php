<?php

include 'autoload.php';
include 'routes/web.php';

use App\Core\Router;

$router = new Router();
$router->run();