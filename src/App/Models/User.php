<?php

namespace App\Models;

use App\Traits\Database;

class User {
  use Database;

  static function getUser($username) {
    $data = ['username' => $username];

    return self::query('SELECT id, username, profile_picture, password FROM users WHERE username = :username', $data);
  }

  static function getUserbyUsername($username) {
    $data = [
      'username' => $username
    ];
    return self::query("SELECT username, password FROM users WHERE username = :username", $data);
  }

  static function getUsername($username) {
    $data = ['username' => $username];

    return self::query("SELECT username from users WHERE username = :username", $data);
  }

  static function getEmail($email) {
    $data = ['email' => $email];

    return self::query("SELECT email from users WHERE email = :email", $data);
  }

  static function getMobile($mobile) {
    $data = ['mobile' => $mobile];

    return self::query("SELECT mobile from users WHERE mobile = :mobile", $data);
  }
}
