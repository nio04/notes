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
    if ($this->isLoggedIn) {

      // get note details
      $note = new Notes();
      $note = $note->getNote($id);

      // save the note in session
      $this->setSession("note", $note[0]);

      // save the value in a variable to prevent not-edited error
      $id = $note[0]->id;
      $title = $note[0]->title;
      $description = $note[0]->description;
      $keywords = $note[0]->keywords;


      return $this->render("noteUpdate", ['username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'id' => $id, 'title' => $title, 'description' => $description, 'keywords' => $keywords]);
    } else {
      return $this->render("login");
    }
  }

  function upload() {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $attachment = $_FILES['attachment'] ?? "";

    // sanitize
    list($title, $description, $keywords) = $this->sanitize([$title, $description, $keywords]);

    // check if note Updated
    $contentUpdated =  $this->checkIfUdated($title, $description, $keywords);

    if (is_array($contentUpdated)  && isset($contentUpdated[0])) {
      return $this->render("noteUpdate", ['errors' => $contentUpdated, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'title' => $title, 'description' => $description, 'keywords' => $keywords,]);
    }

    // upload to table
    $note = new Notes();
    $note->save(['id' => (int)$id, 'user_id' => $this->getSession(['user', 'id']), 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'attachment' => $attachment]);

    redirect("");
  }
}
