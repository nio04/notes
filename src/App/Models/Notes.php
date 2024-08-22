<?php

namespace App\Models;

use App\Traits\Database;

class Notes {
  use Database;

  function getShortNotes($user_id) {
    $data = ['user_id' => $user_id];

    return $this->query("SELECT id, title, created_at FROM notes WHERE user_id = :user_id", $data);
  }

  function getNote($id) {
    $data = ["id" => (int) $id];

    return $this->query("SELECT * FROM notes WHERE id = :id", $data);
  }

  function getTitle(string $title) {
    $data = ['title' => $title];
    return $this->query("SELECT title FROM notes WHERE title = :title", $data);
  }

  /**
   * create note on db table
   * @param array $data
   * @return mixed
   */
  function upload(array $data) {
    return $this->query("INSERT INTO notes (user_id, title, description, keywords, attachment) VALUES (:user_id, :title, :description, :keywords, :attachment)", $data);
  }

  function deleteNote($id) {
    $data = ["id" => (int) $id];
    return $this->query("DELETE FROM notes WHERE id = :id", $data);
  }

  function save($data) {
    return $this->query("UPDATE notes SET user_id = :user_id, title = :title, description = :description, keywords = :keywords, attachment = :attachment WHERE id = :id ", $data);
  }
}
