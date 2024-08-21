<?php loadPartials("header") ?>

<div class="flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl m-20">
    <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
    <form action="/register/submit" method="POST" enctype="multipart/form-data">

      <?php loadPartials("errors",  ['errors' => $errors ?? []]) ?>

      <div class="mb-4">
        <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name</label>
        <input type="text" id="first_name" name="first_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php $first_name ?? '' ?>">
      </div>
      <div class="mb-4">
        <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name</label>
        <input type="text" id="last_name" name="last_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php $last_name ?? "" ?>">
      </div>
      <div class="mb-4">
        <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php $username ?? "" ?>">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php $email ?? "" ?>">
      </div>
      <div class="mb-4">
        <label for="dob" class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
        <input type="date" id="dob" name="dob" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="mobile" class="block text-gray-700 font-semibold mb-2">Mobile Number</label>
        <input type="text" id="mobile" name="mobile" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php $mobile ?? "" ?>">
      </div>
      <div class="mb-4">
        <label for="profile_picture" class="block text-gray-700 font-semibold mb-2">Profile Picture</label>
        <input type="file" id="profile_picture" name="profile_picture" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-6">
        <label for="password_confirm" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
        <input type="password" id="password_confirm" name="password_confirm" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="flex justify-between items-center mt-12">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
          Register
        </button>
        <a href="/login" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
          Go to Login
        </a>
      </div>
    </form>
  </div>
  <?php loadPartials("footer") ?>
