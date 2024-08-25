<?php loadPartials("header") ?>

<div class="flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm mt-24">
    <h2 class="text-2xl font-bold text-center mb-6">Log Out</h2>

    <form action="/logout/submit" method="POST">

      <?php if (!empty($errors['logoutError'])): ?>
        <p class="text-red-500 text-sm mt-2 mb-6"><?php echo $errors['loginError']; ?></p>
      <?php endif; ?>

      <!-- Username Field -->
      <div class="mb-4">
        <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
          value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>">

        <?php if (!empty($errors['username'])): ?>
          <p class="text-red-500 text-sm mt-2"><?php echo $errors['username']; ?></p>
        <?php endif; ?>
      </div>

      <!-- Password Field -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

        <?php if (!empty($errors['password'])): ?>
          <p class="text-red-500 text-sm mt-2"><?php echo $errors['password']; ?></p>
        <?php endif; ?>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mx-auto mt-4">
          Log out
        </button>
      </div>
    </form>
  </div>
</div>

<?php loadPartials("footer") ?>
