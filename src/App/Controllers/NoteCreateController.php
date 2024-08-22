<?php

namespace App\Controllers;

use Core\Controller;

class NoteCreateController extends Controller {

  function index() {
    if ($this->isLoggedIn) {
      return $this->render("noteCreate");
    } else {
      return $this->render("login");
    }
  }
}
