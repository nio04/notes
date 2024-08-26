<?php

namespace App\Controllers;

use App\Models\Notes;
use App\Traits\Session;
use App\Traits\Validation;
use Core\Controller;

class NoteSearchController extends Controller {
  use Session;
  use Validation;

  function index() {
    if (!$this->isLoggedIn) {
      return $this->render("login");
    }

    return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'isHomepage' => $this->isHomepage, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'notes' => $this->shortNotes, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
  }

  function search() {
    $query = $_GET['query'];

    // sanitize
    $query = self::sanitize($query);

    // if query is less than 3 char
    if (strlen($query) < 3) {
      return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'isHomepage' => $this->isHomepage, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'query' => $query, 'notes' => $this->shortNotes, 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);
    }

    // perform a search
    $noteSearch = Notes::noteSearch($query);
    $noteSearchResults = Notes::noteSearchCount($query);

    return $this->render("notes", ['isLoggedIn' => $this->isLoggedIn, 'isHomepage' => $this->isHomepage, 'username' => $this->username, 'profile_picture' => $this->profile_picture, 'isNoteCreatePage' => $this->isNoteCreatePage, 'query' => $query, 'notes' => $this->shortNotes, 'noteSearch' => $noteSearch, 'noteSearchCount' => $noteSearchResults[0]->total ?? "", 'page' => $this->page, 'perPage' => $this->limit, 'totalNotes' => $this->totalNotes]);

    // redirect('');
  }
}
