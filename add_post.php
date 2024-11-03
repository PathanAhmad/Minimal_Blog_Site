<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category_id = (int)$_POST['category'];  // Casting to integer for safety
    $user_id = $_SESSION['user_id'];
    $publish_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO blog_posts (title, content, category_id, user_id, publish_date) 
            VALUES ('$title', '$content', $category_id, $user_id, '$publish_date')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Post added successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- HTML Form to Add a New Post -->
<form method="POST">
    <input type="text" name="title" placeholder="Post Title" required>
    <textarea name="content" placeholder="Post Content" required></textarea>
    <select name="category" required>
        <?php
        $categories = $conn->query("SELECT * FROM categories");
        while ($category = $categories->fetch_assoc()) {
            echo "<option value='{$category['id']}'>{$category['name']}</option>";
        }
        ?>
    </select>
    <button type="submit">Add Post</button>
</form>
