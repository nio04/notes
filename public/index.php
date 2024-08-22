<?php

session_start();

use Framework\Router;

require "../vendor/autoload.php";
require "../helpers.php";

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();

echo ("<pre>");
var_dump($_SESSION);
echo ("</pre>");
