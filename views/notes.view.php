<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['notes' => $notes ?? [], 'isNoteCreatePage' => $isNoteCreatePage]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4"></div>

  <?php loadPartials("footer") ?>
