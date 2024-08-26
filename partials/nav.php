<nav class="bg-blue-600 p-4 flex justify-between items-center fixed top-0 w-full z-10">
  <!-- Left side link -->
  <div class="text-yellow-400 text-xl font-semibold">
    <a href="/">Notishes</a>
  </div>

  <!-- Search Bar (only on homepage) -->
  <?php if ($isHomepage ?? ""): ?>
    <div class=" mx-auto">
      <form action="/notes/search" method="GET" class="relative">
        <input type="text" name="query" placeholder="Search..." class="w-80 px-8 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($_GET['query'] ?? "") ?>">
        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-400 text-white font-semibold px-3 py-1 rounded-lg hover:bg-green-500">
          Search
        </button>
      </form>
    </div>
  <?php endif; ?>

  <!-- Right side profile section -->
  <div class="flex items-center space-x-4">
    <span class="text-white"><?= $username ?></span>
    <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden">
      <img src="<?php echo loadPicture("users/profilePictures/$profile_picture"); ?>" alt="User Avatar" class="w-full h-full object-cover">
    </div>

    <!-- Logout button if the user is logged in -->
    <?php if ($isLoggedIn): ?>
      <a href="/logout"
        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
        Logout
      </a>
    <?php endif; ?>
  </div>
</nav>
