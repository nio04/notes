<?php

namespace App\Controllers;

use App\Traits\Validation;
use Core\Controller;

class NoteCreateController extends Controller {
  use Validation;

  function index() {
    if ($this->isLoggedIn) {
      return $this->render("noteCreate");
    } else {
      return $this->render("login");
    }
  }


  function save() {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $file = $_FILES['file'];

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
  }
}
