<?php
include "../includes/functions.php";
requireLogin();

$post = [
    'id' => '',
    'title' => '',
    'content' => '',
];

$editing = false;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM blog_post WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $postData = $result->fetch_assoc();
    if ($postData && $postData['user_id'] == $_SESSION['user_id']) {
        $post = $postData;
        $editing = true;
    } else {
        die("Unauthorized access.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editing ? "Edit Blog" : "New Blog" ?> - WordWeave</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="editor-page">
    <section class="container editor-container">
        <h2 class="editor-title"><?= $editing ? "Edit Blog" : "Create New Blog" ?></h2>

        <form action="<?php echo BASE_URL; ?>posts/save_post.php" method="post" enctype="multipart/form-data" class="editor-form">
            <input type="hidden" name="id" value="<?= e($post['id']); ?>">

            <!-- Blog Title -->
            <div class="form-group">
                <label for="title" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600;">Title</label>
                <input type="text" id="title" name="title" class="form-input" placeholder="Enter a catchy title..." required value="<?= e($post['title']); ?>">
            </div>

            <!-- Blog Content -->
            <div class="form-group" style="margin-top: 20px;">
                <label for="content" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600;">Content</label>
                <textarea id="content" name="content" class="form-textarea" placeholder="Write your thoughts here..." rows="12" required><?= e($post['content']); ?></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px;">
                <?= $editing ? "Update Blog" : "Publish Blog" ?>
            </button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> WordWeave. All rights reserved.</p>
</footer>
</body>
</html>
