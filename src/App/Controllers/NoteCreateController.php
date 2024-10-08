<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Validation;
use Core\Controller;

class NoteCreateController extends Controller {
  use Validation;

  function index() {
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }
    return $this->render("noteCreate", ['isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'isNoteCreatePage' => $this->isNoteCreatePage, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }


  function save() {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $attachment = $_FILES['file'];

    //sanitze
    list($title, $description, $keywords) = $this->sanitize([$title, $description, $keywords]);

    // check if title, description fields empty
    $requiredFields = ['title', 'description'];
    $checkEmpty = $this->isEmpty(['title' => $title, 'description' => $description], $requiredFields);

    if (is_array($checkEmpty)) {
      return $this->render('noteCreate', ['errors' => $checkEmpty, 'isLoggedIn' => $this->isLoggedIn, 'isNoteCreatePage' => $this->isNoteCreatePage, 'profile_picture' => $this->profile_picture, 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'notes' => $this->shortNotes, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // validate
    /**
     * if description has content then title can not be empty
     * and if title have content, then description can be empty
     */
    if (strlen(trim($description)) > 0 && strlen(trim($title)) === 0) {
      $errors['noteError'] = 'title can not be empty!';

      return $this->render('noteCreate', ['errors' => $errors, 'isLoggedIn' => $this->isLoggedIn, 'isNoteCreatePage' => $this->isNoteCreatePage, 'profile_picture' => $this->profile_picture, 'description' => $description, 'keywords' => $keywords, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // validate attachment
    $this->handleFileUpload($attachment, 'uploads/users/attachments/');

    // check if the title already exist
    $titleExist = Notes::getTitle($title, $user_id = self::getSession(['user', 'id']));

    if ($titleExist) {
      $errors['noteError'] = 'this title is already in use!';

      return $this->render('noteCreate', ['errors' => $errors, 'isLoggedIn' => $this->isLoggedIn, 'username' => $this->username, 'title' => $title, 'isNoteCreatePage' => $this->isNoteCreatePage, 'profile_picture' => $this->profile_picture, 'notes' => $this->shortNotes, 'description' => $description, 'keywords' => $keywords, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // insert to table
    Notes::upload(['user_id' => $this->getSession(['user', 'id']), 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'attachment' => $attachment['name']]);

    self::setSession(['message'], 'note successfully created');

    redirect("");
  }
}
