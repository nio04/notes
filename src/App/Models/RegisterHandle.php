<?php

namespace App\Models;

use App\Traits\Database;
use Core\Model;

class RegisterHandle extends Model {
  use Database;

  static function save($data) {
    // save the user in table
    return self::query("INSERT INTO users (first_name, last_name, username, email, mobile, dob, profile_picture, password) VALUES (:first_name, :last_name, :username, :email, :mobile, :dob, :profile_picture, :password)", $data);
  }
}
