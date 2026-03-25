<?php
include "functions.php";
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

    <title>My Profile - MyBlog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="container profile-page">
    <section class="profile-header">
        <h2 class="profile-title">Welcome, <?= e($user['username']); ?></h2>
        <p class="profile-email">Email: <?= e($user['email']); ?></p>
        <a href="editor.php" class="btn create-btn">+ Create New Blog</a>
    </section>

    <section class="my-blogs">
        <h3 class="section-title">My Blogs</h3>
        <div class="blog-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="blog-card">
                    <?php if (!empty($row['image'])): ?>
                        <div class="blog-image">
                            <img src="uploads/<?= e($row['image']); ?>" alt="Blog Image">
                        </div>
                    <?php endif; ?>

                    <div class="blog-content">
                        <h2 class="blog-title">
                            <a href="view.php?id=<?= $row['id']; ?>"><?= e($row['title']); ?></a>
                        </h2>
                        <p class="blog-meta">Created on <?= date('F j, Y', strtotime($row['created_at'])); ?></p>
                        
                        <div class="blog-actions">
                            <a href="editor.php?id=<?= $row['id']; ?>" class="btn edit-btn">Edit</a>
                            <a href="delete_post.php?id=<?= $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

</body>
</html>
