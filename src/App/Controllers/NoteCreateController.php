<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Validation;
use Core\Controller;

class NoteCreateController extends Controller {
  use Validation;

  function index() {
    if ($this->isLoggedIn) {
      return $this->render("noteCreate", ['username' => $this->username, 'profile_picture' => $this->profile_picture]);
    } else {
      return $this->render("login");
    }
  }


  function save() {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $attachment = $_FILES['file'];

    //sanitze
    list($title, $description, $keywords) = $this->sanitize([$title, $description, $keywords]);

    // validate
    /**
     * if description has content then title can not be empty
     * and if title have content, then description can be empty
     */
    if (strlen(trim($description)) > 0 && strlen(trim($title)) === 0) {
      return $this->render('noteCreate', ['errors' => ['title can not be empty!'], 'description' => $description, 'keywords' => $keywords]);
    }

    // validate attachment
    $this->handleFileUpload($attachment, 'uploads/users/attachments');

    // check if the title already exist
    $note = new Notes();
    $titleExist = $note->getTitle($title);

    if ($titleExist) {
      return $this->render('noteCreate', ['errors' => ['this title is already in use!'], 'title' => $title, 'description' => $description, 'keywords' => $keywords]);
    }

    // insert to table
    $note->upload(['user_id' => $this->getSession(['user', 'id']), 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'attachment' => $attachment['name'], 'version' => 0]);

    redirect("");
  }
}
