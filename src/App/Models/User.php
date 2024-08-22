<?php

namespace App\Models;

use App\Traits\Database;

class User {
  use Database;

  function getUserbyUsername($username) {
    $data = [
      'username' => $username
    ];
    return $this->query("SELECT username, password FROM users WHERE username = :username", $data);
  }
}
