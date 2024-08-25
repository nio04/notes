<?php

session_start();

use Framework\Router;

require "../vendor/autoload.php";
require "../helpers.php";

Router::autoRegisterRoute();
Router::dispatch();

// unset($_SESSION["user"]);
// unset($_SESSION["message"]);

// echo ("<pre>");
// var_dump($_SESSION);
// echo ("</pre>");
