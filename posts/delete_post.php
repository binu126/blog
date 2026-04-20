<?php
include "../includes/functions.php";
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "pages/index.php");
    exit;
}

$post_id = (int)$_GET['id'];

// Fetch post
$stmt = $conn->prepare("SELECT * FROM blog_post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    header("Location: " . BASE_URL . "pages/index.php");
    exit;
}

// Check permissions (author or admin)
if ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "pages/index.php");
    exit;
}

// Delete post
$stmt = $conn->prepare("DELETE FROM blog_post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

header("Location: " . BASE_URL . "pages/profile.php");
exit;
?>
