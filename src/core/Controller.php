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
  protected $page;
  protected $limit = 10;
  protected $offset;
  protected $totalNotes;

  function __construct() {
    $notes = new Notes();
    // pagination
    $this->page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $this->offset = ($this->page - 1) * $this->limit;
    $this->totalNotes = $notes->calculateTotalPage();

    $this->isLoggedIn = $this->hasSession('user');
    $this->username = $this->getSession(['user', 'username']);
    $this->profile_picture = $this->getSession(['user', 'profile_picture']);
    $this->shortNotes = $notes->getShortNotes($this->getSession(['user', 'id']), $this->limit, $this->offset);
    $this->isNoteCreatePage = $_SERVER['REQUEST_URI'] === "/notes/create";
  }
}
