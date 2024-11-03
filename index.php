<?php
include 'db.php';
session_start();

$logged_in = isset($_SESSION['user_id']);

// Set the number of posts per page
$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories");

// Handle category filter
$category_filter = isset($_GET['category']) && $_GET['category'] != '' ? $_GET['category'] : null;
$where_clause = $category_filter ? "WHERE blog_posts.category_id = $category_filter" : '';

// Fetch posts and count total posts for pagination
$sql = "SELECT blog_posts.*, users.username, categories.name AS category_name 
        FROM blog_posts
        JOIN users ON blog_posts.user_id = users.id
        JOIN categories ON blog_posts.category_id = categories.id
        $where_clause
        ORDER BY blog_posts.publish_date DESC 
        LIMIT $offset, $posts_per_page";
$result = $conn->query($sql);

$total_posts_sql = "SELECT COUNT(*) AS total FROM blog_posts $where_clause";
$total_posts = $conn->query($total_posts_sql)->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $posts_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogging Platform</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #f2f2f2; margin: 0; padding: 20px;">

    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; color: #333;">Blog Posts</h1>
        <div>
            <?php if (!$logged_in): ?>
                <a href="login.php" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0;">Login to Add Blog Post</a>
            <?php else: ?>
                <a href="dashboard.php" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0;">Go to Dashboard</a>
                <a href="logout.php" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0; margin-left: 8px;">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <form method="GET" action="index.php" style="margin-bottom: 20px;">
        <label for="category" style="font-weight: bold;">Filter by Category:</label>
        <select name="category" id="category" onchange="this.form.submit()" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-left: 10px;">
            <option value="">All Categories</option>
            <?php while ($category = $categories->fetch_assoc()): ?>
                <option value="<?php echo $category['id']; ?>" 
                    <?php echo isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($post = $result->fetch_assoc()): ?>
                <article style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                    <h2 style="color: #333; margin: 0;"><?php echo htmlspecialchars($post['title']); ?></h2>
                    <p style="color: #777; margin: 8px 0;">By <?php echo htmlspecialchars($post['username']); ?> | 
                        Category: <a href="category.php?id=<?php echo $post['category_id']; ?>" style="color: #555;"><?php echo htmlspecialchars($post['category_name']); ?></a>
                    </p>
                    <p style="color: #444;">
                        <?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 100))); ?>...
                        <a href="post.php?id=<?php echo $post['id']; ?>" style="color: #007bff;">Read More</a>
                    </p>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #777;">No posts available.</p>
        <?php endif; ?>
    </div>

    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <?php if ($page > 1): ?>
            <a href="index.php?page=<?php echo $page - 1; ?>&category=<?php echo $category_filter; ?>" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0; margin-right: 5px;">Previous</a>
        <?php endif; ?>

        <?php
        // Loop through page numbers
        for ($i = 1; $i <= $total_pages; $i++): 
            if ($i == $page): ?>
                <span style="padding: 8px 12px; color: #fff; background-color: #333; border-radius: 5px; margin-right: 5px;"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="index.php?page=<?php echo $i; ?>&category=<?php echo $category_filter; ?>" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0; margin-right: 5px;"><?php echo $i; ?></a>
            <?php endif; 
        endfor;
        ?>

        <?php if ($page < $total_pages): ?>
            <a href="index.php?page=<?php echo $page + 1; ?>&category=<?php echo $category_filter; ?>" style="text-decoration: none; color: #333; padding: 8px 12px; border: 1px solid #333; border-radius: 5px; background-color: #e0e0e0; margin-left: 5px;">Next</a>
        <?php endif; ?>
    </div>

</body>
</html>
