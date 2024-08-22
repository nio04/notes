<?php if (!empty($errors)): ?>
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-full mb-8" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">Please fix the following errors:</span>
    <ul class="mt-2 list-disc list-inside">
      <?php foreach ($errors ?? [] as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>
