<?php

namespace App\Models;

use App\Traits\Database;

class Notes {
  use Database;

  function getShortNotes($user_id) {
    $data = ['user_id' => $user_id];

    return $this->query("SELECT id, title, created_at FROM notes WHERE user_id = :user_id ORDER BY created_at DESC", $data);
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
  function saveToOldNotes($data) {
    return $this->query("INSERT INTO old_notes (users_id, notes_id, title, description, keywords, attachment) VALUES(:users_id, :notes_id, :title, :description, :keywords, :attachment)", $data);
  }

  function getSingleOldNote($id) {
    $data = ["id" => (int) $id];

    return $this->query("SELECT * FROM old_notes WHERE id = :id", $data);
  }

  /**
   * load old notes when clicked from side bar
   * @param mixed $id
   * @return mixed
   */
  function getOldNotesFromSideBar($id) {
    $data = ["notes_id" => (int) $id];
    return $this->query("SELECT id, notes_id, title, created_at FROM old_notes WHERE notes_id = :notes_id", $data);
  }

  /**
   * load old notes when clicked from menu (under the noteview) 
   * 
   * 
   * @param int $notes_id notes_id (foreign key)
   * @param int $id specific id (specific to the old note)
   */
  function getOldNotes($notes_id, $id) {
    $data = ["notes_id" => (int) $notes_id, 'id' => $id];
    return $this->query("SELECT id, notes_id, title, created_at FROM old_notes WHERE notes_id = :notes_id AND id != :id", $data);
  }
}
