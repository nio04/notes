<?php

namespace App\Models;

use App\Traits\Database;

class User {
  use Database;

  function getUser($username) {
    $data = ['username' => $username];

    return $this->query('SELECT id, username FROM users WHERE username = :username', $data);
  }

  function getUserbyUsername($username) {
    $data = [
      'username' => $username
    ];
    return $this->query("SELECT username, password FROM users WHERE username = :username", $data);
  }

  function getUsername($username) {
    $data = ['username' => $username];

    return $this->query("SELECT username from users WHERE username = :username", $data);
  }

  function getEmail($email) {
    $data = ['email' => $email];

    return $this->query("SELECT email from users WHERE email = :email", $data);
  }

  function getMobile($mobile) {
    $data = ['mobile' => $mobile];

    return $this->query("SELECT mobile from users WHERE mobile = :mobile", $data);
  }
}
