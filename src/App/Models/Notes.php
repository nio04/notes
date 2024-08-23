<?php

namespace App\Models;

use App\Traits\Database;
use App\Traits\Session;

class Notes {
  use Database;
  use Session;

  /**
   * get note id, title, created value from 'note' table to show at sidebar
   * @param int $user_id
   * @param int $limit
   * @param int $offset
   * @return mixed
   */
  function getShortNotes($user_id, $limit, $offset) {
    $data = ['user_id' => $user_id];

    return $this->query("SELECT id, title, created_at FROM notes WHERE user_id = :user_id ORDER BY created_at DESC LIMIT $limit OFFSET $offset", $data);
  }

  function getNote($id) {
    $data = ["id" => (int) $id];

    return $this->query("SELECT * FROM notes WHERE id = :id ORDER BY created_at DESC", $data);
  }

  /**
   * used for check if title already exist
   * @param string $title
   * @return mixed
   */
  function getTitle(string $title) {
    $data = ['title' => $title];
    return $this->query("SELECT title FROM notes WHERE title = :title", $data);
  }

  /**
   * create note on 'notes' table
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
  /**
   * save the old note on 'old_notes' table
   * @param array $data
   * @return mixed
   */
  function saveToOldNotes($data) {
    return $this->query("INSERT INTO old_notes (users_id, notes_id, title, description, keywords, attachment) VALUES(:users_id, :notes_id, :title, :description, :keywords, :attachment)", $data);
  }

  /**
   * get note info for old notes when clicked one old note
   * @param mixed $id
   * @return mixed
   */
  function getSingleOldNote($id) {
    $data = ["id" => (int) $id];
    return $this->query("SELECT * FROM old_notes WHERE id = :id", $data);
  }

  /**
   * load old notes when clicked from menu (under the noteview) 
   * 
   * @param int $notes_id notes_id (foreign key)
   * @param int $id specific id (specific to the old note)
   */
  function getOldNotes($notes_id, $id, $limit, $offset) {
    $data = ["notes_id" => (int) $notes_id, 'id' => $id];
    return $this->query("SELECT id, notes_id, title, created_at FROM old_notes WHERE notes_id = :notes_id AND id != :id ORDER BY created_at DESC  LIMIT $limit OFFSET $offset", $data);
  }

  function calculateTotalPage() {
    $data = ['user_id' => $this->getSession(['user', 'id'])];

    $notes = $this->query("SELECT COUNT(*) AS totalNotes FROM notes where user_id = :user_id", $data)[0];
    return $notes->totalNotes;
  }
}
