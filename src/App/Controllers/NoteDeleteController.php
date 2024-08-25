<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use Core\Controller;

class NoteDeleteController extends Controller {
  use Session;

  function index($id) {
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }

    Notes::deleteNote($id);
    self::setSession(['message'], 'note successfully deleted');
    redirect("");
  }
}
