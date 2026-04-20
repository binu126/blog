<?php
include "../includes/functions.php";
requireLogin();

$user_id = $_SESSION['user_id'];
$user = getUser($conn, $user_id);

// Fetch user blogs
$stmt = $conn->prepare("SELECT * FROM blog_post WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - WordWeave</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="container profile-page">
    <section class="profile-header" style="text-align: center; margin-bottom: 50px;">
        <h2 class="profile-title">Welcome, <?= e($user['username']); ?>!</h2>
        <p class="profile-email" style="color: var(--text-muted); margin-bottom: 30px;">Logged in as: <?= e($user['email']); ?></p>
        <a href="<?php echo BASE_URL; ?>pages/editor.php" class="btn-primary" style="text-decoration: none;">+ Create New Blog</a>
    </section>

    <section class="my-blogs">
        <h3 class="section-title" style="margin-bottom: 30px;">My Blogs</h3>
        <div class="blog-list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="blog-card">
                        <div class="blog-card-content">
                            <h2 class="blog-card-title">
                                <a href="<?php echo BASE_URL; ?>posts/view.php?id=<?= $row['id']; ?>"><?= e($row['title']); ?></a>
                            </h2>
                            <p class="blog-card-meta">Created on <?= date('F j, Y', strtotime($row['created_at'])); ?></p>
                            
                            <div class="blog-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                                <a href="<?php echo BASE_URL; ?>pages/editor.php?id=<?= $row['id']; ?>" class="btn-primary" style="background: var(--accent) !important; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4); text-decoration: none;">Edit</a>
                                <a href="<?php echo BASE_URL; ?>posts/delete_post.php?id=<?= $row['id']; ?>" class="btn-primary" style="background: var(--danger) !important; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4); text-decoration: none;" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; color: var(--text-muted); grid-column: 1 / -1;">You haven't written any blogs yet.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> WordWeave. All rights reserved.</p>
</footer>
</body>
</html>
