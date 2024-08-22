<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteViewController extends Controller {
  use Session;

  function index($id) {
    if ($this->isLoggedIn) {

      // get the note
      $note = new Notes();
      $note = $note->getNote($id);

      return $this->render("noteView", ['notes' => $this->shortNotes, 'note' => $note[0]]);
    } else {
      return $this->render("login");
    }
  }
}
