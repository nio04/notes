<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteController extends Controller {
  use Session;

  function index() {
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }
    return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'isHomepage' => $this->isHomepage, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }
}
