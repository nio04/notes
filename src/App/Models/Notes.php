<?php

namespace App\Models;

use App\Traits\Database;

class Notes {
  use Database;

  function getTitle(string $title) {
    $data = ['title' => $title];
    return $this->query("SELECT title FROM notes WHERE title = :title", $data);
  }

  function upload(array $data) {
    return $this->query("INSERT INTO notes (user_id, title, description, keywords, attachment, version) VALUES (:user_id, :title, :description, :keywords, :attachment, :version)", $data);
  }
}
