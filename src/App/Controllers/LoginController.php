<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\Session;
use App\Traits\Validation;
use Core\Controller;

class LoginController extends Controller {
  use Validation;
  use Session;

  function index() {
    $this->render("login");
  }

  function submit() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // sanitize
    list($username, $password) = $this->sanitize([$username, $password]);

    // check if empty
    $requiredFields = ['username', 'password'];
    $isEmpty = $this->isEmpty(['username' => $username, 'password' => $password], $requiredFields);

    if (is_array($isEmpty) && isset($isEmpty[0])) {
      return $this->render("login", ['errors' => $isEmpty]);
    }

    $user = new User();
    $user = $user->getUserbyUsername($username);

    if (empty($user)) {
      return $this->render("login", ['errors' => ['username or password is incorrect']]);
    }

    if (is_array($user)) {
      $passwordVerify = password_verify($password, $user[0]->password);

      if ($passwordVerify === true) {
        // save the user in session [got only username, password]
        $this->setSession(['user'], $user[0]);

        redirect("notes");
      } else {
        return $this->render("login", ['errors' => ['username or password is incorrect']]);
      }
    } else {
      return $this->render("login", ['errors' => ['something went wrong']]);
    }
  }
}
