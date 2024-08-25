<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ['isHomepage' => $isHomepage, "username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn, 'query' => $query ?? ""]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['notes' => $notes ?? [], 'isNoteCreatePage' => $isNoteCreatePage, 'page' => $page, 'perPage' => $perPage, 'totalNotes' => $totalNotes]) ?>

  <!-- Right Content Area -->
  <div class="ml-auto w-2/3 bg-white p-6 pb-6 h-screen">

    <?php if (!empty($query) && !empty($noteSearch)): ?>
      <!-- Search Results Found Section -->
      <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Search Results Found: <?= number_format($noteSearchCount) ?></h2>
        <!-- Search Results Container -->
        <div class="grid grid-cols-2 gap-4">
          <?php foreach ($noteSearch as $note): ?>
            <a href="/notes/view/<?= htmlspecialchars($note->id); ?>" class="block p-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-blue-600">
              <?= htmlspecialchars($note->title); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php elseif (!empty($query)): ?>
      <!-- No Search Results Section -->
      <p class="text-gray-600 text-center text-lg md:text-xl lg:text-2xl font-semibold mt-6">
        No search results found.
      </p>
    <?php endif; ?>
  </div>

  <?php loadPartials("footer") ?>
</div>
