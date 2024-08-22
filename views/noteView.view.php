<?php

$keywords = $note->keywords ?? "";
$keywords = explode(", ", $keywords);

?>

<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ["notes" => $notes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4">

    <div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-8">

      <!-- Top Right Buttons (Update & Delete) -->
      <div class="flex justify-end space-x-4 mb-6">
        <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">Update</button>
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
        <div class="h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
          No attachments uploaded
        </div>
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
      <div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-8">

        <!-- Old Versions List (Scrollable) -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Old Versions</h3>
        <div class="max-h-40 overflow-y-auto">
          <ul class="space-y-2">
            <li class="bg-gray-100 text-gray-800 p-4 rounded-lg flex justify-between">
              <span class="font-semibold text-gray-600">title 1 (v1)</span>
              <span class="text-gray-500 text-sm">Created on: 2023-08-01</span>
            </li>
            <li class="bg-gray-100 text-gray-800 p-4 rounded-lg flex justify-between">
              <span class="font-semibold text-gray-600">title 2 (v2)</span>
              <span class="text-gray-500 text-sm">Created on: 2023-08-02</span>
            </li>
            <li class="bg-gray-100 text-gray-800 p-4 rounded-lg flex justify-between">
              <span class="font-semibold text-gray-600">title 3 (v3)</span>
              <span class="text-gray-500 text-sm">Created on: 2023-08-03</span>
            </li>
            <!-- Add more versions as needed -->
          </ul>
        </div>
      </div>
    </div>
    <?php loadPartials("footer") ?>
