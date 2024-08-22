<?php

namespace App\Models;

use App\Traits\Database;
use Core\Model;

class RegisterHandle extends Model {
  use Database;

  function save($data) {
    // query
    return $this->query("INSERT INTO users (first_name, last_name, username, email, mobile, dob, profile_picture, password) VALUES (:first_name, :last_name, :username, :email, :mobile, :dob, :profile_picture, :password)", $data);
  }
}
