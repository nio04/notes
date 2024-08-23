<?php

namespace App\Controllers;

use App\Traits\Session;
use Core\Controller;

class LogoutController extends Controller {
  use Session;

  function index() {
    $this->removeSession('user');
    redirect('');
  }
}
