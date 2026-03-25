<?php
include "functions.php";
requireLogin();

$title = trim($_POST['title']);
$content = trim($_POST['content']);
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$user_id = $_SESSION['user_id'];

// Update existing post
if ($id) {
    $stmt = $conn->prepare("SELECT user_id FROM blog_post WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $post = $stmt->get_result()->fetch_assoc();
    if (!$post || $post['user_id'] != $user_id) die("Unauthorized");

    // Update title and content only
    $stmt = $conn->prepare("UPDATE blog_post SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: view.php?id=$id");
    exit;
}

// Insert new post
$stmt = $conn->prepare("INSERT INTO blog_post (user_id, title, content) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $content);
$stmt->execute();
$newId = $conn->insert_id;

header("Location: view.php?id=$newId");
exit;
?>
