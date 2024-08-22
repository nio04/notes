<?php

function loadPartials(string $file, array $data = []) {
  extract($data);
  require __DIR__ . "/partials/" . $file . ".php";
}

function redirect($path) {
  header("location: /" . $path);
}
