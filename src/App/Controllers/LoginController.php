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
    return $this->render("login");
  }

  function submit() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // sanitize
    list($username, $password) = $this->sanitize([$username, $password]);

    // check if empty
    $requiredFields = ['username', 'password'];
    $isEmpty = $this->isEmpty(['username' => $username, 'password' => $password], $requiredFields);

    if (is_array($isEmpty)) {
      return $this->render("login", ['errors' => $isEmpty]);
    }

    $user = new User();
    $user = $user->getUserbyUsername($username);

    if (empty($user)) {
      $errors['loginError'] = 'username or password is incorrect';
      return $this->render("login", ['errors' => $errors]);
    }

    if (is_array($user)) {
      $passwordVerify = password_verify($password, $user[0]->password);

      if ($passwordVerify === true) {
        $user = User::getUser($username);

        // save the user in session 
        $this->setSession(['user'], $user[0]);

        redirect("notes");
      } else {
        $errors['loginError'] = 'username or password is incorrect';
        return $this->render("login", ['errors' => $errors]);
      }
    } else {
      $errors['loginError'] = 'something went wrong';
      return $this->render("login", ['errors' => $errors]);
    }
  }
}
