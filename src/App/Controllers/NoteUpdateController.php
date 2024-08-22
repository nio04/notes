<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteUpdateController extends Controller {
  use Session;

  function index($id) {
    if ($this->isLoggedIn) {

      // get note details
      $note = new Notes();
      $note = $note->getNote($id);

      return $this->render("noteUpdate", ['username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'note' => $note[0]]);
    } else {
      return $this->render("login");
    }
  }
}
