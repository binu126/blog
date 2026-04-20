<?php
include "../includes/functions.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        die("Title and Content are required.");
    }

    // Update existing post
    if ($id) {
        $stmt = $conn->prepare("SELECT user_id FROM blog_post WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();
        
        if (!$post || $post['user_id'] != $user_id) {
            die("Unauthorized");
        }

        $stmt = $conn->prepare("UPDATE blog_post SET title=?, content=?, updated_at=NOW() WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();

        header("Location: " . BASE_URL . "posts/view.php?id=$id");
        exit;
    } else {
        // Insert new post
        $stmt = $conn->prepare("INSERT INTO blog_post (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);
        $stmt->execute();
        $newId = $conn->insert_id;

        header("Location: " . BASE_URL . "posts/view.php?id=$newId");
        exit;
    }
} else {
    header("Location: " . BASE_URL . "pages/index.php");
    exit;
}
?>
