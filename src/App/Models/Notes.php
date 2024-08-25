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
  static function getShortNotes($user_id, $limit, $offset) {
    $data = ['user_id' => $user_id];

    return self::query("SELECT id, title, created_at FROM notes WHERE user_id = :user_id ORDER BY updated_at DESC LIMIT $limit OFFSET $offset", $data);
  }

  static function getNote($id) {
    $data = ["id" => (int) $id];

    return self::query("SELECT * FROM notes WHERE id = :id ORDER BY created_at DESC", $data);
  }

  /**
   * used for check if title already exist
   * @param string $title
   * @return mixed
   */
  static function getTitle(string $title, $user_id) {
    $data = ['title' => $title, 'user_id' => $user_id];
    return self::query("SELECT title FROM notes WHERE title = :title AND user_id = :user_id", $data);
  }

  /**
   * create note on 'notes' table
   * @param array $data
   * @return mixed
   */
  static function upload(array $data) {
    return self::query("INSERT INTO notes (user_id, title, description, keywords, attachment) VALUES (:user_id, :title, :description, :keywords, :attachment)", $data);
  }

  static function deleteNote($id) {
    $data = ["id" => (int) $id];
    return self::query("DELETE FROM notes WHERE id = :id", $data);
  }

  static function save($data) {
    return self::query("UPDATE notes SET user_id = :user_id, title = :title, description = :description, keywords = :keywords, attachment = :attachment WHERE id = :id ", $data);
  }
  /**
   * save the old note on 'old_notes' table
   * @param array $data
   * @return mixed
   */
  static function saveToOldNotes($data) {
    return self::query("INSERT INTO old_notes (users_id, notes_id, title, description, keywords, attachment) VALUES(:users_id, :notes_id, :title, :description, :keywords, :attachment)", $data);
  }

  /**
   * get note info for old notes when clicked one old note
   * @param mixed $id
   * @return mixed
   */
  static function getSingleOldNote($id) {
    $data = ["id" => (int) $id];
    return self::query("SELECT * FROM old_notes WHERE id = :id", $data);
  }

  /**
   * load old notes when clicked from menu (under the noteview) 
   * 
   * @param int $notes_id notes_id (foreign key)
   * @param int $id specific id (specific to the old note)
   */
  static function getOldNotes($notes_id, $id, $limit, $offset) {
    $data = ["notes_id" => (int) $notes_id, 'id' => $id];
    return self::query("SELECT id, notes_id, title, created_at FROM old_notes WHERE notes_id = :notes_id AND id != :id ORDER BY created_at DESC  LIMIT $limit OFFSET $offset", $data);
  }

  static function calculateTotalPage() {
    $data = ['user_id' => self::getSession(['user', 'id'])];

    $notes = self::query("SELECT COUNT(*) AS totalNotes FROM notes where user_id = :user_id", $data)[0];
    return $notes->totalNotes;
  }
}
