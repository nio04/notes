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
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }

    // save the note id to our parent controller
    $this->activeNote = (int) $id;

    // get the note
    $singleNote = Notes::getNote($id);
    $oldNotes = Notes::getOldNotes($id, $id, $this->limit, $this->offset);

    return $this->render("noteView", ['viewingOldNote' => false, 'isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'note' => $singleNote[0] ?? [], 'activeNote' => $this->activeNote, 'isNoteCreatePage' => $this->isNoteCreatePage, 'oldNotes' => $oldNotes ?? [], 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }

  /**
   * when clicked on one old note, this method open the old note in a noteView
   * @param mixed $id
   * @return void
   */
  function viewOldNotes($id) {
    $oldNoteId = $this->sanitize($id); // specific id
    $notes_id = $this->sanitize($_POST['notes_id']); // notes_id 

    // get the note
    $singleNote = Notes::getSingleOldNote($oldNoteId);
    $oldNotes = Notes::getOldNotes($notes_id, $oldNoteId, $this->limit, $this->offset);

    return $this->render("noteView", ['viewingOldNote' => true, 'isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'note' => $singleNote[0] ?? [], 'isNoteCreatePage' => $this->isNoteCreatePage, 'oldNotes' => $oldNotes ?? [], 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }
}
