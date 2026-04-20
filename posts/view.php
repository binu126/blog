<?php
include "../includes/functions.php";

if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "pages/index.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("
    SELECT b.*, u.username 
    FROM blog_post b 
    JOIN user u ON b.user_id = u.id 
    WHERE b.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if (!$blog) {
    die("Blog not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($blog['title']); ?> - WordWeave</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="blog-view-page">
    <section class="container blog-view-container">
        <article class="blog-view-card">
            <header class="blog-view-header">
                <h1 class="blog-title" style="text-align: left; background: none; -webkit-text-fill-color: initial; color: var(--text-main); margin-bottom: 10px;"><?php echo e($blog['title']); ?></h1>
                <p class="blog-meta" style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 30px;">
                    By <span class="blog-author" style="font-weight: 600; color: var(--primary);"><?php echo e($blog['username']); ?></span> 
                    on <span class="blog-date"><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                </p>
            </header>

            <div class="blog-content" style="font-size: 1.1rem; line-height: 1.8; color: #334155;">
                <?php echo nl2br(e($blog['content'])); ?>
            </div>

            <div style="margin-top: 50px; border-top: 1px solid #e2e8f0; padding-top: 30px;">
                <a href="<?php echo BASE_URL; ?>pages/index.php" class="btn-primary" style="text-decoration: none;">&larr; Back to Home</a>
            </div>
        </article>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> WordWeave. All rights reserved.</p>
</footer>
</body>
</html>
