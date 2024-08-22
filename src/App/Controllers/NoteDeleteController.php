<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteDeleteController extends Controller {
  use Session;

  function index($id) {
    if ($this->isLoggedIn) {

      // delete
      $note = new Notes();
      $note->deleteNote($id);

      redirect("");
      // return $this->render("notes", ['username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes]);
    } else {
      return $this->render("login");
    }
  }
}
