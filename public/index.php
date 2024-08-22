<?php

session_start();

use Framework\Router;

require "../vendor/autoload.php";
require "../helpers.php";

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();

// unset($_SESSION["user"]);

echo ("<pre>");
var_dump($_SESSION);
echo ("</pre>");
