<?php loadPartials("header") ?>

<div class="flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm mt-24">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
    <form action="/login/submit" method="POST">

      <?php loadPartials("errors",  ['errors' => $errors ?? []]) ?>

      <div class="mb-4">
        <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
          Login
        </button>
        <a href="/register" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
          Go to Register
        </a>
      </div>
    </form>
  </div>

  <?php loadPartials("footer") ?>
