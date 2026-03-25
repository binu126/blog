<?php
include "functions.php";
requireLogin();

$user_id = $_SESSION['user_id'];
$user = getUser($conn, $user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update Profile
    if (isset($_POST['update_profile'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $stmt = $conn->prepare("UPDATE user SET username=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $email, $user_id);
        $stmt->execute();
        echo "<script>alert('Profile updated successfully!');</script>";
    }

    // Change Password
    if (isset($_POST['change_password'])) {
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];

        $stmt = $conn->prepare("SELECT password FROM user WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (password_verify($current, $result['password'])) {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE user SET password=? WHERE id=?");
            $update->bind_param("si", $hash, $user_id);
            $update->execute();
            echo "<script>alert('Password changed successfully!');</script>";
        } else {
            echo "<script>alert('Current password is incorrect!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Settings - MyBlog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="<?= isset($_SESSION['theme']) && $_SESSION['theme'] === 'dark' ? 'dark-theme' : '' ?>">
<?php include "header.php"; ?>

<div class="container settings-page">
    <h2>Settings</h2>

    <div class="settings-section">
        <h3>Edit Profile</h3>
        <form method="post">
            <input type="text" name="username" value="<?= e($user['username']); ?>" required>
            <input type="email" name="email" value="<?= e($user['email']); ?>" required>
            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>

    <div class="settings-section">
        <h3>Change Password</h3>
        <form method="post">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>
</div>

</body>
</html>
