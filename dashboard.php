<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's posts
$sql = "SELECT blog_posts.*, categories.name AS category_name 
        FROM blog_posts
        JOIN categories ON blog_posts.category_id = categories.id
        WHERE user_id = $user_id
        ORDER BY publish_date DESC";
$user_posts = $conn->query($sql);

// Fetch categories for new post creation
$categories = $conn->query("SELECT * FROM categories");

// Handle new category creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_category'])) {
    $new_category_name = $conn->real_escape_string($_POST['new_category_name']);
    $conn->query("INSERT INTO categories (name) VALUES ('$new_category_name')");
    header("Location: dashboard.php"); // Refresh to show new category
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; color: #333; display: flex; justify-content: center; padding: 20px;">

<div style="background-color: #fff; padding: 20px; border-radius: 8px; width: 600px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; color: #333;">User Dashboard</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="index.php" style="color: #333; text-decoration: none; margin-right: 15px;">Back to Home</a> |
        <a href="logout.php" style="color: #333; text-decoration: none; margin-left: 15px;">Logout</a>
    </div>

    <!-- User's Posts List -->
    <h2 style="color: #333;">Your Blog Posts</h2>
    <?php if ($user_posts->num_rows > 0): ?>
        <?php while ($post = $user_posts->fetch_assoc()): ?>
            <div style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                <h3 style="margin: 0; color: #333;"><?php echo htmlspecialchars($post['title']); ?></h3>
                <p style="margin: 5px 0; color: #666;">Category: <?php echo htmlspecialchars($post['category_name']); ?></p>
                <div>
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" style="color: #333; text-decoration: none; margin-right: 10px;">Edit</a> |
                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" style="color: #333; text-decoration: none; margin-left: 10px;" onclick="return confirm('Delete this post?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color: #666;">You have no blog posts yet.</p>
    <?php endif; ?>

    <!-- Create New Post Form -->
    <h2 style="color: #333;">Create New Post</h2>
    <form method="POST" action="add_post.php" style="display: flex; flex-direction: column;">
        <input type="text" name="title" placeholder="Title" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <textarea name="content" placeholder="Content" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
        <select name="category" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php echo htmlspecialchars($cat['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" style="padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Create Post</button>
    </form>

    <!-- Add New Category Form -->
    <h2 style="color: #333; margin-top: 20px;">Add New Category</h2>
    <form method="POST" action="dashboard.php" style="display: flex; flex-direction: column;">
        <input type="text" name="new_category_name" placeholder="Category Name" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <button type="submit" name="new_category" style="padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add Category</button>
    </form>
</div>

</body>
</html>
