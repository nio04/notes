<div class="w-1/3 bg-gray-200 p-4 fixed h-full grid grid-rows-layout pt-12">
  <!-- Create Note Button -->
  <?php if (!$isNoteCreatePage ?? ''): ?>
    <div class="mb-8 row-start-1 row-end-2">
      <a href="/notes/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 block text-center">
        Create a New Note
      </a>
    </div>
  <?php endif ?>

  <!-- Notes Section -->
  <div class="overflow-y-auto row-start-2 row-end-3 mb-32">
    <?php if (!empty($notes)): ?>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">All the Notes</h2>
      <div>
        <?php foreach ($notes as $index => $note): ?>
          <a href="/notes/view/<?= $note->id ?>" class="block">
            <div class="bg-white p-4 rounded-lg shadow mb-4 note-item grid grid-cols-[auto_1fr] items-center">
              <!-- Note Index -->
              <div class="note-index bg-blue-600 text-white text-sm font-bold rounded-full w-6 h-6 flex items-center justify-center mr-3">
                <?= ($page - 1) * $perPage + $index + 1 ?>
              </div>
              <!-- Note Title -->
              <h3 class="font-semibold text-gray-700 note-title"><?= htmlspecialchars($note->title) ?></h3>
            </div>
          </a>
        <?php endforeach ?>
      </div>
      <!-- Load More Button -->
      <?php if ($page * $perPage < $totalNotes): ?>
        <div class="text-center mt-6">
          <button id="loadMoreBtnLeft" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Load More
          </button>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div class="bg-gray-100 p-4 rounded-lg shadow mt-auto">
        <h3 class="font-semibold text-gray-400 text-center">No notes were found</h3>
      </div>
    <?php endif; ?>
  </div>

  <!-- JavaScript for Load More Button -->
  <script>
    const loadMoreBtnLeft = document.getElementById('loadMoreBtnLeft');
    if (loadMoreBtnLeft) {
      loadMoreBtnLeft.addEventListener('click', function() {
        const currentPage = <?= $page ?>;
        window.location.href = `?page=${currentPage + 1}`;
      });
    }
  </script>

</div>
