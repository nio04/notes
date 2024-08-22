<?php

namespace Core;

use App\Models\Notes;
use App\Traits\Session;

class Controller extends View {
  use Session;

  protected $isLoggedIn;
  protected $shortNotes;
  protected $username;
  protected $profile_picture;
  protected $isNoteCreatePage;

  function __construct() {
    $notes = new Notes();
    $this->isLoggedIn = $this->hasSession('user');
    $this->username = $this->getSession(['user', 'username']);
    $this->profile_picture = $this->getSession(['user', 'profile_picture']);
    $this->shortNotes = $notes->getShortNotes($this->getSession(['user', 'id']));
    $this->isNoteCreatePage = $_SERVER['REQUEST_URI'] === "/notes/create";
  }
}
