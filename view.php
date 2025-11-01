<?php
include "functions.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
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
    echo "<p class='not-found-msg'>Blog not found!</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($blog['title']); ?> - MyBlog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="blog-view-page">
    <section class="container blog-view-container">
        <article class="blog-view-card">
            <header class="blog-view-header">
                <h1 class="blog-title"><?php echo e($blog['title']); ?></h1>
                <p class="blog-meta">
                    By <span class="blog-author"><?php echo e($blog['username']); ?></span> 
                    on <span class="blog-date"><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                </p>
            </header>

            <?php if (!empty($blog['image'])): ?>
                <div class="blog-image-wrapper">
                    <img src="uploads/<?php echo e($blog['image']); ?>" 
                         alt="Blog Image" 
                         class="blog-image">
                </div>
            <?php endif; ?>

            <div class="blog-content">
                <?php echo nl2br(e($blog['content'])); ?>
            </div>
        </article>
    </section>
</main>

</body>
</html>
