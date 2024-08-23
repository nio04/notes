<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['notes' => $notes ?? [], 'isNoteCreatePage' => $isNoteCreatePage, 'page' => $page, 'perPage' => $perPage, 'totalNotes' => $totalNotes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-6 pb-6">
    <!-- Notes Listing -->
    <?php if (empty($notes)): ?>
      <div class="bg-gray-100 p-6 rounded-lg shadow mb-6 text-center">
        <h3 class="font-semibold text-gray-700">No notes found</h3>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-2 gap-6">
        <?php foreach ($notes as $index => $note): ?>
          <a href="/notes/view/<?= $note->id ?>" class="block">
            <div class="relative bg-blue-100 p-6 rounded-lg shadow hover:shadow-lg transition duration-300 h-full flex flex-col justify-between">
              <h3 class="text-lg font-semibold text-gray-800 mb-4"><?= $note->title ?></h3>
              <p class="text-sm text-gray-600 self-end"><?= date("F j, Y", strtotime($note->created_at)) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Load More Button -->
      <?php if ($page * $perPage < $totalNotes): ?>
        <div class="text-center mt-12">
          <button id="loadMoreBtnRight" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Load More
          </button>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- JavaScript for Load More Button -->
  <script>
    const loadMoreBtnRight = document.getElementById('loadMoreBtnRight');
    if (loadMoreBtnRight) {
      loadMoreBtnRight.addEventListener('click', function() {
        const currentPage = <?= $page ?>;
        window.location.href = `?page=${currentPage + 1}`;
      });
    }
  </script>


  <?php loadPartials("footer") ?>
</div>
