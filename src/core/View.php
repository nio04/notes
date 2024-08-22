<?php

namespace Core;

class View {
  function render($fileName, $data = []) {
    extract($data);
    require __DIR__ . "/../../views/" . $fileName . ".view.php";
  }
}
