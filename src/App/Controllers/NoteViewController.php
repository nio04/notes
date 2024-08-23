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
      $singleNote = $note->getNote($id);
      $oldNotes = $note->getOldNotes($id);

      return $this->render("noteView", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'note' => $singleNote[0], 'isNoteCreatePage' => $this->isNoteCreatePage, 'oldNotes' => $oldNotes]);
    } else {
      return $this->render("login");
    }
  }
}
