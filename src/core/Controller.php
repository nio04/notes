<?php

namespace Core;

use App\Models\Notes;
use App\Traits\Session;

class Controller extends View {
  use Session;

  protected $isLoggedIn;
  protected $shortNotes;

  function __construct() {
    $notes = new Notes();
    $this->isLoggedIn = $this->hasSession('user');
    $this->shortNotes = $notes->getShortNotes($this->getSession(['user', 'id']));
  }
}
