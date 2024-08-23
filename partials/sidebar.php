<div class="w-1/3 bg-gray-200 p-4 fixed h-full flex flex-col justify-between pt-12">
  <!-- Create Note Button -->
  <?php if (!$isNoteCreatePage ?? ''): ?>
    <div class="mb-8">
      <a href="/notes/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 block text-center">
        Create a New Note
      </a>
    </div>
  <?php endif ?>

  <!-- Notes Section -->
  <div class="flex flex-col h-80 mb-28">
    <?php if (!empty($notes)): ?>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">All the Notes</h2>
      <div class="flex-grow overflow-y-auto">
        <?php foreach ($notes as $note): ?>
          <a href="/notes/view/<?= $note->id ?>" class="block">
            <div class="bg-white p-4 rounded-lg shadow mb-4 note-item">
              <h3 class="font-semibold text-gray-700 note-title"><?= $note->title ?></h3>
            </div>
          </a>
        <?php endforeach ?>

      </div>
    <?php else: ?>
      <div class="bg-gray-100 p-4 rounded-lg shadow mb-4 mt-auto w-full">
        <h3 class="font-semibold text-gray-400 text-center">No notes were found</h3>
      </div>
    <?php endif; ?>
  </div>
</div>
