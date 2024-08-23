<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use App\Traits\Validation;
use Core\Controller;

class NoteViewController extends Controller {
  use Session;
  use Validation;

  function index($id) {
    if ($this->isLoggedIn) {

      // get the note
      $note = new Notes();
      $singleNote = $note->getNote($id);
      $oldNotes = $note->getOldNotesFromSideBar($id);

      return $this->render("noteView", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'note' => $singleNote[0] ?? [], 'isNoteCreatePage' => $this->isNoteCreatePage, 'oldNotes' => $oldNotes ?? []]);
    } else {
      return $this->render("login");
    }
  }

  function viewOldNotes($id) {
    if ($this->isLoggedIn) {
      $oldNoteId = $this->sanitize($id); // specific id
      $notes_id = $this->sanitize($_POST['notes_id']); // notes_id 

      // get the note
      $note = new Notes();
      $singleNote = $note->getSingleOldNote($oldNoteId);
      $oldNotes = $note->getOldNotes($notes_id, $oldNoteId);

      return $this->render("noteView", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'note' => $singleNote[0] ?? [], 'isNoteCreatePage' => $this->isNoteCreatePage, 'oldNotes' => $oldNotes ?? []]);
    } else {
      return $this->render("login");
    }
  }
}
