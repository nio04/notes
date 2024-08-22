<?php


namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {

  function index() {
    $this->render("login");
  }
}
