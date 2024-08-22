<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['isNoteCreatePage' => $isNoteCreatePage, 'notes' => $notes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4">
    <div class="p-8 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-8">

      <!-- Header Title for Updating Note -->
      <h2 class="text-4xl font-bold text-gray-800 mb-6">Update Note</h2>

      <!-- Update Note Form -->
      <form>
        <!-- Title Input -->
        <div class="mb-4">
          <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Title</label>
          <input type="text" id="title" name="title" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500" value="<?= $note->title ?? "" ?>">
        </div>

        <!-- Description Input -->
        <div class="mb-4">
          <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
          <textarea id="description" name="description" rows="4" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"><?= $note->description ?? "" ?></textarea>
        </div>

        <!-- Keywords Input -->
        <div class="mb-4">
          <label for="keywords" class="block text-lg font-medium text-gray-700 mb-2">Keywords</label>
          <input type="text" id="keywords" name="keywords" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500" value="<?= $note->keywords ?? "" ?>">
        </div>

        <!-- File Attachment Input -->
        <div class="mb-6">
          <label for="attachment" class="block text-lg font-medium text-gray-700 mb-2">File Attachment</label>
          <input type="file" id="attachment" name="attachment" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500" value="<?= $note->attachment ?? "" ?>">
        </div>

        <!-- Buttons: Close Editor & Update Note -->
        <div class="flex justify-end space-x-4">
          <a href="/notes" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">Close Editor</a>
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">Update Note</button>
        </div>
      </form>
    </div>
  </div>

  <?php loadPartials("footer") ?>
