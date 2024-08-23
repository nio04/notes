<div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mt-8 absolute right-0 w-8/12">
  <h3 class="text-xl font-semibold text-gray-800 mb-4">Old Versions</h3>

  <div class="max-h-40 overflow-y-auto">
    <?php if (!empty($oldNotes)): ?>
      <ul class="space-y-2">
        <?php foreach ($oldNotes as $oldNote): ?>
          <form action="/notes/viewOld/<?= $oldNote->id ?>" method="POST" class="bg-gray-100 text-gray-800 p-4 rounded-lg flex justify-between hover:bg-gray-200">
            <input type="hidden" name="notes_id" value="<?= $oldNote->notes_id ?>">

            <!-- Submit button that displays the note details -->
            <button type="submit" class="flex justify-between w-full text-left">
              <span class="font-semibold text-gray-600"><?= htmlspecialchars($oldNote->title) ?></span>

              <!-- Format the date and time -->
              <span class="text-gray-500 text-sm">
                <?php
                $date = new DateTime($oldNote->created_at);
                echo $date->format('F j, Y, g:i A');
                ?>
              </span>
            </button>

          </form>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="text-gray-600 p-4 rounded-lg bg-gray-50">
        We could not find any old versions of the current note.
      </div>
    <?php endif; ?>
  </div>
</div>
