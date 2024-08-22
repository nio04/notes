<?php

namespace App\Controllers;

use Core\Controller;

class NoteController extends Controller {
  function index() {
    $this->render("notes");
  }
}
