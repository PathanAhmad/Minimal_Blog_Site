<?php
include 'db.php';
session_start();

$category_id = $_GET['id'];

// Fetch posts belonging to the selected category
$sql = "SELECT blog_posts.*, users.username, categories.name AS category_name 
        FROM blog_posts
        JOIN users ON blog_posts.user_id = users.id
        JOIN categories ON blog_posts.category_id = categories.id
        WHERE categories.id = $category_id
        ORDER BY publish_date DESC";

$result = $conn->query($sql);

// Fetch the category name for display
$category_result = $conn->query("SELECT name FROM categories WHERE id = $category_id");
$category_name = $category_result->fetch_assoc()['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: <?php echo $category_name; ?></title>
</head>
<body>
    <h1>Posts in <?php echo $category_name; ?></h1>

    <?php while ($post = $result->fetch_assoc()): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p>By: <?php echo $post['username']; ?></p>
        <p><?php echo $post['content']; ?></p>
        <hr>
    <?php endwhile; ?>

    <a href="index.php">Back to Home</a>
</body>
</html>
