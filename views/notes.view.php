<?php

echo ("<pre>");
var_dump($isLoggedIn);
echo ("</pre>");

?>

<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav") ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar") ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4"></div>

  <?php loadPartials("footer") ?>
