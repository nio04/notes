<?php

namespace App\Controllers;

use App\Traits\Session;
use App\Traits\Validation;
use Core\Controller;

class LogoutController extends Controller {
  use Session;
  use Validation;

  function index() {
    return $this->render("logout");
  }

  function logout() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // sanitize
    list($username, $password) = self::sanitize([$username, $password]);

    // check if empty
    $requiredFields = ['username', 'password'];
    $checkEmpty = self::isEmpty(['username' => $username, 'password' => $password], $requiredFields);

    if (is_array($checkEmpty)) {
      return $this->render("logout", ['errors' => $checkEmpty]);
    }

    // check if username & password matches
    $storeUserName = self::getSession(['user', 'username']);
    $storePassword = self::getSession(['user', 'password']);

    if ($username === $storeUserName) {
      $matchPassword = password_verify($password, $storePassword);

      // remove the user from session if password matches
      if ($matchPassword) {
        $this->removeSession('user');
        redirect('');
      }
    }
  }
}
