<?php

namespace Core;

use App\Traits\Session;

class Controller extends View {
  use Session;

  protected $isLoggedIn;

  function __construct() {
    $this->isLoggedIn = $this->hasSession('user');
  }
}
