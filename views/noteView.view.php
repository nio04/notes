<?php

$keywords = $note->keywords ?? "";
$keywords = explode(", ", $keywords);
echo ("<pre>");
var_dump($note->attachment);
echo ("</pre>");

?>

<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ["notes" => $notes, 'isNoteCreatePage' => $isNoteCreatePage]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4">

    <div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-8">

      <!-- Top Right Buttons (Update & Delete) -->
      <div class="flex justify-end space-x-4 mb-6">
        <a
          href="/notes/update/<?= $note->id ?>"
          class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
          Update
        </a>

        <a
          href="/notes/delete/<?= $note->id ?>"
          class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
          onclick="return confirm('Are you sure you want to delete this?');">
          Delete
        </a>
      </div>

      <!-- Note Title -->
      <h2 class="text-4xl font-bold text-gray-800 mb-4"><?= $note->title ?></h2>

      <!-- Note Description -->
      <p class="text-gray-700 text-lg leading-relaxed mb-6 pl-8">
        <?= $note->description ?>
      </p>

      <!-- Keywords Section -->
      <div class="my-12 mt-20">
        <h3 class="text-sm font-semibold text-gray-800 mb-2">Keywords:</h3>
        <?php foreach ($keywords as $keyword): ?>
          <span class="inline-block bg-gray-200 text-gray-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded"><?= $keyword ?></span>
        <?php endforeach ?>
      </div>

      <!-- Attachment Placeholder -->
      <div class="mb-6 mt-20">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Attachments:</h3>

        <?php if ($note->attachment ?? ""): ?>
          <!-- Display image if $attachment is truthy -->
          <div class="h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
            <img src="<?php echo loadPicture("users/attachments/$note->attachment"); ?>" alt="Attachment" class="max-w-full max-h-full object-contain">
          </div>
        <?php elseif (is_null($note->attachment ?? "")): ?>
          <!-- Message if no attachment is provided -->
          <div class="h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
            No attachment could be found
          </div>
        <?php else: ?>
          <!-- Message for other cases, if necessary -->
          <div class="h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
            Could not load the attachment
          </div>
        <?php endif; ?>
      </div>


      <!-- Close Editor Button -->
      <a href="/" class="block">
        <div class="flex justify-center mb-10">
          <div class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
            Close View
          </div>
        </div>
      </a>

      <!-- Old Notes Version Container -->
      <?php loadPartials("oldNotes", ['oldNotes' => $oldNotes]) ?>
    </div>
    <?php loadPartials("footer") ?>
