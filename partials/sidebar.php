<div class="w-1/3 bg-gray-200 p-4 fixed h-full flex flex-col justify-between">
  <?php if (!$isNoteCreatePage ?? ''): ?>
    <div class="m-8">
      <a href="/notes/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 block text-center">
        Create a New Note
      </a>
    </div>
  <?php endif ?>

  <div class="overflow-y-auto flex-grow mb-24 flex flex-col">
    <?php if (empty($notes)): ?>
      <div class="bg-gray-100 p-4 rounded-lg shadow mb-4 mt-auto w-full">
        <h3 class="font-semibold text-gray-400 text-center">No notes were found</h3>
      </div>
    <?php else: ?>
      <?php foreach ($notes as $note): ?>
        <a href="/notes/view/<?= $note->id ?>" class="block">
          <div class="bg-white p-4 rounded-lg shadow mb-4">
            <h3 class="font-semibold text-gray-700"><?= $note->title ?></h3>
          </div>
        </a>
      <?php endforeach ?>
    <?php endif; ?>
  </div>

</div>
