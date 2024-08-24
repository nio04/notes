<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['notes' => $notes ?? [], 'isNoteCreatePage' => $isNoteCreatePage, 'page' => $page, 'perPage' => $perPage, 'totalNotes' => $totalNotes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-6 pb-6"> </div>
  <?php loadPartials("footer") ?>
</div>
