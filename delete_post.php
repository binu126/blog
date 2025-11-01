<?php
include "functions.php";
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$post_id = (int)$_GET['id'];

// Fetch post
$stmt = $conn->prepare("SELECT * FROM blog_post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    $_SESSION['error'] = "Post not found!";
    header("Location: index.php");
    exit;
}

// Check permissions (author or admin)
if ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You don't have permission to delete this post!";
    header("Location: index.php");
    exit;
}

// Delete post
$stmt = $conn->prepare("DELETE FROM blog_post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

$_SESSION['success'] = "Post deleted successfully!";
header("Location: index.php");
exit;
?>
