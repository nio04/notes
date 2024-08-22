<?php


namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class HomeController extends Controller {
  use Session;

  function index() {

    if ($this->isLoggedIn) {
      $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'notes' => $this->shortNotes]);
    } else {
      $this->render("login");
    }
  }
}
