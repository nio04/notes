<?php

namespace App\Controllers;

use Core\Controller;

class NoteController extends Controller {

  function index() {
    if ($this->isLoggedIn) {
      return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn]);
    } else {
      return $this->render("login");
    }
  }
}
