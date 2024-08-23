<?php


namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class HomeController extends Controller {
  use Session;

  function index() {

    if (!$this->isLoggedIn) {
      return $this->render("login");
    }
    return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'isNoteCreatePage' => $this->isNoteCreatePage, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }
}
