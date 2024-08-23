<?php

$keywords = $note->keywords ?? "";
$keywords = explode(", ", $keywords);

?>

<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn]) ?>

<!-- Main container -->
<div class="pt-16 relative">

  <?php loadPartials("sidebar", ["notes" => $notes, 'isNoteCreatePage' => $isNoteCreatePage, 'page' => $page, 'perPage' => $perPage, 'totalNotes' => $totalNotes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4">
    <div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-8 space-y-12">

      <!-- Top Right Buttons (Update & Delete) -->
      <div class="flex justify-end space-x-4 mb-6">
        <a href="/notes/update/<?= $note->id ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
          Update
        </a>
        <a href="/notes/delete/<?= $note->id ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
          onclick="return confirm('Are you sure you want to delete this?');">
          Delete
        </a>
      </div>

      <!-- Note Title and Date-Time -->
      <div class="space-y-2">
        <h2 class="text-4xl font-bold text-gray-800"><?= $note->title ?></h2>
        <p class="text-sm text-gray-500">
          <?= date('F j, Y, g:i a', strtotime($note->created_at)) ?>
        </p>
      </div>

      <!-- Note Description -->
      <div class="p-6 bg-gray-50 rounded-lg">
        <p class="text-gray-700 text-lg leading-relaxed">
          <?= $note->description ?>
        </p>
      </div>

      <!-- Keywords Section -->
      <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-800">Keywords:</h3>
        <?php if (empty($keywords[0])): ?>
          <p class="text-gray-600">No keywords were found.</p>
        <?php else: ?>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($keywords as $keyword): ?>
              <span class="inline-block bg-gray-200 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded"><?= htmlspecialchars($keyword) ?></span>
            <?php endforeach ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Attachment Section -->
      <div class="space-y-4">
        <h3 class="text-xl font-semibold text-gray-800">Attachments:</h3>
        <?php if ($note->attachment ?? ""): ?>
          <!-- Display image if $attachment is truthy -->
          <div class="h-60 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
            <img src="<?php echo loadPicture("users/attachments/$note->attachment"); ?>" alt="Attachment" class="max-w-full max-h-full object-contain">
          </div>
        <?php elseif (is_null($note->attachment ?? "")): ?>
          <!-- Message if no attachment is provided -->
          <div class="h-60 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
            No attachment could be found
          </div>
        <?php else: ?>
          <!-- Message for other cases, if necessary -->
          <div class="h-60 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
            Could not load the attachment
          </div>
        <?php endif; ?>
      </div>

      <!-- Close Editor Button -->
      <div class="flex justify-center">
        <a href="/" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300 text-center block">
          Close View
        </a>
      </div>
    </div>
  </div>


  <!-- Old Notes Version Container -->
  <?php loadPartials("oldNotes", ['oldNotes' => $oldNotes]) ?>
</div>
<?php loadPartials("footer") ?>
