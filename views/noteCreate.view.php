<?php loadPartials("header") ?>

<!-- Navigation Bar -->
<?php loadPartials("nav", ["username" => $username, 'profile_picture' => $profile_picture, 'isLoggedIn' => $isLoggedIn]) ?>

<!-- Main container -->
<div class="flex pt-16">

  <?php loadPartials("sidebar", ['notes' => $notes, 'isNoteCreatePage' => $isNoteCreatePage, 'page' => $page, 'perPage' => $perPage, 'totalNotes' => $totalNotes]) ?>

  <!-- Right Content Area  -->
  <div class="ml-auto w-2/3 bg-white p-4">
    <!-- Note Creation Form -->
    <div class="p-8 bg-white rounded-lg shadow-lg max-w-3xl mx-auto">
      <!-- Header -->
      <h2 class="text-3xl font-bold text-gray-800 mb-6">Create Note</h2>

      <!-- Form -->
      <form action="/notes/save" method="POST" enctype="multipart/form-data">

        <?php if (!empty($errors['noteError'])): ?>
          <p class="text-red-500 text-sm mt-2 mb-6"><?php echo $errors['noteError']; ?></p>
        <?php endif; ?>

        <!-- Title Input -->
        <div class="mb-6">
          <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" id="title" name="title" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter note title" value="<?= $title ?? "" ?>">

          <?php if (!empty($errors['title'])): ?>
            <p class="text-red-500 text-sm mt-2"><?php echo $errors['title']; ?></p>
          <?php endif; ?>
        </div>

        <!-- Description Textarea -->
        <div class="mb-6">
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter note description"><?= $description ?? "" ?></textarea>
          <?php if (!empty($errors['description'])): ?>
            <p class="text-red-500 text-sm mt-2"><?php echo $errors['description']; ?></p>
          <?php endif; ?>
        </div>

        <!-- Keywords Input -->
        <div class="mb-6">
          <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
          <input type="text" id="keywords" name="keywords" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter keywords" value="<?= $keywords ?? "" ?>">
        </div>

        <!-- File Attachment -->
        <div class="mb-6">
          <label for="file" class="block text-sm font-medium text-gray-700">Attach File</label>
          <input type="file" id="file" name="file" class="mt-1 block w-full text-gray-500">
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
          <a href="/notes" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-300">Close Create View</a>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Create Note</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php loadPartials("footer") ?>
