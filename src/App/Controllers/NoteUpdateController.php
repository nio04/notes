<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use App\Traits\Validation;
use Core\Controller;

class NoteUpdateController extends Controller {
  use Session;
  use Validation;

  function index($id) {
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }

    // get note details
    $note = Notes::getNote($id);

    // save the note in session
    $this->setSession("note", $note[0]);

    // save the value in a variable to prevent not-edited error
    $id = $note[0]->id;
    $title = $note[0]->title;
    $description = $note[0]->description;
    $keywords = $note[0]->keywords;

    return $this->render("noteUpdate", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'id' => $id, 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }

  function upload() {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $attachment = $_FILES['attachment'] ?? "";

    // sanitize
    list($title, $description, $keywords) = $this->sanitize([$title, $description, $keywords]);

    // check if the title already exist
    $titleExist = Notes::getTitle($title, $user_id = self::getSession(['user', 'id']));

    if ($titleExist) {
      return $this->render('noteUpdate', ['errors' => ['this title is already in use!'], 'isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'title' => $title, 'isNoteCreatePage' => $this->isNoteCreatePage, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'description' => $description, 'keywords' => $keywords, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // check if note Updated
    $contentUpdated =  $this->checkIfUdated($title, $description, $keywords);

    if (is_array($contentUpdated)  && isset($contentUpdated[0])) {
      return $this->render("noteUpdate", ['errors' => $contentUpdated, 'isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // upload to table [curren(new)note]
    Notes::save(['id' => (int)$id, 'user_id' => $this->getSession(['user', 'id']), 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'attachment' => $attachment]);

    // upload to old_notes table (old note)
    Notes::saveToOldNotes(['users_id' => $this->getSession(['note', 'user_id']), 'notes_id' => $this->getSession(['note', 'id']), 'title' => $this->getSession(['note', 'title']), 'description' => $this->getSession(['note', 'description']), 'keywords' => $this->getSession(['note', 'keywords']), 'attachment' => $this->getSession(['note', 'attachment'])]);

    // clear note from session
    $this->removeSession('note');
    redirect("");
  }
}
