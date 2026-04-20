<?php
include "../includes/functions.php";
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
        $success = "Profile updated successfully!";
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
            $success = "Password changed successfully!";
        } else {
            $error = "Current password is incorrect!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - WordWeave</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="container settings-page">
    <h2 class="settings-title">Account Settings</h2>

    <?php if (isset($success)): ?>
        <p class="success" style="margin-bottom: 20px;"><?= $success; ?></p>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p class="error" style="margin-bottom: 20px;"><?= $error; ?></p>
    <?php endif; ?>

    <div class="settings-section">
        <h3 style="margin-bottom: 20px; color: var(--primary);">Edit Profile</h3>
        <form method="post">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Username</label>
                <input type="text" name="username" value="<?= e($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Email Address</label>
                <input type="email" name="email" value="<?= e($user['email']); ?>" required>
            </div>
            <button type="submit" name="update_profile" class="btn-primary" style="width: 100%;">Update Profile</button>
        </form>
    </div>

    <div class="settings-section">
        <h3 style="margin-bottom: 20px; color: var(--primary);">Change Password</h3>
        <form method="post">
            <div class="form-group">
                <input type="password" name="current_password" placeholder="Current Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="new_password" placeholder="New Password" required>
            </div>
            <button type="submit" name="change_password" class="btn-primary" style="width: 100%;">Change Password</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> WordWeave. All rights reserved.</p>
</footer>
</body>
</html>
