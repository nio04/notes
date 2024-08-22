<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteController extends Controller {
  use Session;

  function index() {
    if ($this->isLoggedIn) {

      return $this->render("notes");
    } else {
      return $this->render("login");
    }
  }
}
