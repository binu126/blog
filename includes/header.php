<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="navbar">
  <div class="logo">
    <a href="<?php echo BASE_URL; ?>index.php">Wordweave</a>
  </div>

  <button class="hamburger" id="hamburger" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <nav class="nav-menu" id="navMenu">
    <ul>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="<?php echo BASE_URL; ?>pages/index.php">🏠 Home</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/profile.php">👤 My Profile</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/editor.php">✍️ Create Blog</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/settings.php">⚙️ Settings</a></li>
        <li><a href="<?php echo BASE_URL; ?>auth/logout.php" class="logout-link">🚪 Logout</a></li>
      <?php else: ?>
        <li><a href="<?php echo BASE_URL; ?>pages/index.php">🏠 Home</a></li>
        <li><a href="<?php echo BASE_URL; ?>auth/register.php">📝 Sign Up</a></li>
        <li><a href="<?php echo BASE_URL; ?>auth/login.php">🔑 Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<script>
  const hamburger = document.getElementById('hamburger');
  const navMenu = document.getElementById('navMenu');

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      hamburger.classList.remove('active');
      navMenu.classList.remove('active');
    }
  });
</script>
