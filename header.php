<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<body class="<?= $theme_class; ?>">
<header class="navbar" style="background: linear-gradient(90deg, #3b82f6, #6366f1, #8b5cf6); color: #fff; padding: 0; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);">
  <div class="logo" style="padding: 18px 40px;">
    <a href="index.php" style="font-size: 26px; font-weight: 700; text-decoration: none; background: linear-gradient(90deg, #fff, #fcd34d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; transition: all 0.3s ease;">Wordweave</a>
  </div>

  <!-- Hamburger Button -->
  <button class="hamburger" id="hamburger" aria-label="Toggle menu" style="display: none; flex-direction: column; background: none; border: none; cursor: pointer; padding: 0; z-index: 1001; margin-right: 40px;">
    <span style="width: 25px; height: 3px; background-color: #fff; margin: 3px 0; transition: 0.3s; border-radius: 3px;"></span>
    <span style="width: 25px; height: 3px; background-color: #fff; margin: 3px 0; transition: 0.3s; border-radius: 3px;"></span>
    <span style="width: 25px; height: 3px; background-color: #fff; margin: 3px 0; transition: 0.3s; border-radius: 3px;"></span>
  </button>

  <nav class="nav-menu" id="navMenu" style="flex-grow: 1; display: flex; justify-content: flex-end; margin-right: 20px;">
    <ul style="list-style: none; display: flex; gap: 0; margin: 0; padding: 0; height: 100%;">
      <?php if (isset($_SESSION['user_id'])): ?>
        <li style="height: 100%; display: flex; align-items: center;"><a href="index.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">🏠 Home</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="profile.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">👤 My Profile</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="editor.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">✍️ Create Blog</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="settings.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">⚙️ Settings</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="logout.php" class="logout-btn" style="background: rgba(239, 68, 68, 0.2); color: #fff; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">🚪 Logout</a></li>
      <?php else: ?>
        <li style="height: 100%; display: flex; align-items: center;"><a href="index.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">🏠 Home</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="register.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">📝 Sign Up</a></li>
        <li style="height: 100%; display: flex; align-items: center;"><a href="login.php" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; padding: 18px 24px; font-weight: 500; font-size: 15px; display: flex; align-items: center; border-bottom: 3px solid transparent; transition: all 0.3s ease;">🔑 Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<!-- Hamburger Menu Script -->
<script>
  const hamburger = document.getElementById('hamburger');
  const navMenu = document.getElementById('navMenu');

  // Toggle menu for mobile
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
    navMenu.style.flexDirection = 'column';
    navMenu.style.background = 'linear-gradient(90deg, #3b82f6, #6366f1, #8b5cf6)';
    navMenu.style.position = 'absolute';
    navMenu.style.top = '60px';
    navMenu.style.right = '0';
    navMenu.style.width = '200px';
    navMenu.style.zIndex = '999';

    // Animate hamburger to "X"
    const spans = hamburger.querySelectorAll('span');
    if (hamburger.classList.contains('active')) {
      spans[0].style.transform = 'rotate(-45deg) translate(-5px, 6px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(45deg) translate(-5px, -6px)';
    } else {
      spans.forEach(s => {
        s.style.transform = 'none';
        s.style.opacity = '1';
      });
    }
  });

  // Show hamburger only on small screens
  function resizeMenu() {
    if (window.innerWidth <= 768) {
      hamburger.style.display = 'flex';
      navMenu.style.display = 'none';
    } else {
      hamburger.style.display = 'none';
      navMenu.style.display = 'flex';
      navMenu.style.flexDirection = 'row';
      navMenu.style.justifyContent = 'flex-end';
      navMenu.style.position = 'static';
      navMenu.style.width = 'auto';
      navMenu.style.background = 'none';
    }
  }

  window.addEventListener('resize', resizeMenu);
  window.addEventListener('load', resizeMenu);
</script>
