<?php

use App\config\Router;

require '../config/dev.php';
require '../vendor/autoload.php';
$router = new Router();
$router->run();
