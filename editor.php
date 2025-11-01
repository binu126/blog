<?php
include "functions.php";
requireLogin();

$post = [
    'id' => '',
    'title' => '',
    'content' => '',
    'image' => ''
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
    <title><?= $editing ? "Edit Blog" : "New Blog" ?> - MyBlog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="editor-page">
    <section class="container editor-container">
        <h2 class="editor-title"><?= $editing ? "Edit Blog" : "Create New Blog" ?></h2>

        <form action="save_post.php" method="post" enctype="multipart/form-data" class="editor-form">
            <input type="hidden" name="id" value="<?= e($post['id']); ?>">

            <!-- Blog Title -->
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-input" required value="<?= e($post['title']); ?>">
            </div>

            <!-- Blog Content -->
            <div class="form-group">
                <label for="content" class="form-label">Content</label>
                <textarea id="content" name="content" class="form-textarea" rows="10" required><?= e($post['content']); ?></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">
                <?= $editing ? "Update Blog" : "Publish Blog" ?>
            </button>
        </form>
    </section>
</main>

<script src="assets/js/main.js"></script>

</body>
</html>
