<?php

use Framework\Router;

require "../vendor/autoload.php";
require "../helpers.php";

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();
