<?php


namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class HomeController extends Controller {
  use Session;

  function index() {

    if ($this->isLoggedIn) {
      $notes = new Notes();
      $shortNotes = $notes->getShortNotes($this->getSession(['user', 'id']));

      $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'notes' => $shortNotes]);
    } else {
      $this->render("login");
    }
  }
}
