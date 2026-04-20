<?php
include "../includes/functions.php";

// Search blogs
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
$stmt = $conn->prepare("
    SELECT b.*, u.username 
    FROM blog_post b 
    JOIN user u ON b.user_id = u.id 
    WHERE b.title LIKE ? OR b.content LIKE ? 
    ORDER BY b.created_at DESC
");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - WordWeave</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="home-page">
    <section class="container blog-home-container">

        <!-- 🔍 Search Bar -->
        <div class="search-bar">
            <form method="GET" class="search-form">
                <input type="text" name="search" 
                       class="search-input" 
                       placeholder="Search blogs..." 
                       value="<?php echo isset($_GET['search']) ? e($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <!-- 📝 Blog List -->
        <div class="blog-list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <article class="blog-card">
                        <div class="blog-card-content">
                            <h2 class="blog-card-title">
                                <a href="<?php echo BASE_URL; ?>posts/view.php?id=<?php echo $row['id']; ?>">
                                    <?php echo e($row['title']); ?>
                                </a>
                            </h2>
                            <p class="blog-card-meta">
                                By <span class="author"><?php echo e($row['username']); ?></span>
                                on <span class="date"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></span>
                            </p>
                            <p class="blog-card-excerpt">
                                <?php echo substr(strip_tags($row['content']), 0, 150); ?>...
                            </p>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-blogs-container">
                    <p class="no-blogs-msg">No blogs found. Be the first to write one!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> WordWeave. All rights reserved.</p>
</footer>
</body>
</html>
