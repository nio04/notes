<?php

namespace App\Controllers;

use Core\Controller;

class LoginController extends Controller {
  function index() {
    $this->render("login");
  }

  function submit() {

    echo ("<pre>");
    var_dump($_POST);
    echo ("</pre>");
  }
}
