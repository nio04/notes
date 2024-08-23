<?php

/**
 * $load errors on the view
 * 
 * $data array $value have to be array (??)
 * @param string $file partial file to load
 * @param array $data data to pass on  the partial view 
 * @return void
 */
function loadPartials(string $file, array $data = []) {
  extract($data);
  require __DIR__ . "/partials/" . $file . ".php";
}

function redirect($path) {
  header("location: /" . $path);
}

function loadPicture($fileName) {
  return "/uploads/" . htmlspecialchars($fileName);
}
