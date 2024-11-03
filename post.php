<?php
include 'db.php';
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = $conn->query("SELECT blog_posts.*, users.username, categories.name AS category_name 
                      FROM blog_posts 
                      JOIN users ON blog_posts.user_id = users.id 
                      JOIN categories ON blog_posts.category_id = categories.id 
                      WHERE blog_posts.id = $post_id")->fetch_assoc();

if (!$post) {
    echo "Post not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Blogging Platform</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
            text-align: center;
        }
        .meta {
            color: #777;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #444;
            text-align: justify;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #000;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #e0e0e0;
            text-align: center;
        }
        .back-link:hover {
            background-color: #d0d0d0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p class="meta">By <?php echo htmlspecialchars($post['username']); ?> | Category: <?php echo htmlspecialchars($post['category_name']); ?></p>
        <div class="content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
        <a href="index.php" class="back-link">Back to Homepage</a>
    </div>
</body>
</html>
