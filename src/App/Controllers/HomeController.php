<?php


namespace App\Controllers;

use App\Traits\Session;
use Core\Controller;

class HomeController extends Controller {
  use Session;

  function index() {

    if ($this->isLoggedIn) {
      $this->render("notes", ['isLoggedIn' => $this->isLoggedIn]);
    } else {
      $this->render("login");
    }
  }
}
