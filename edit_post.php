<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];
$sql = "SELECT * FROM blog_posts WHERE id = $post_id";
$post = $conn->query($sql)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use real_escape_string to sanitize inputs
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category_id = $_POST['category'];

    // Update the post with sanitized data
    $sql = "UPDATE blog_posts 
            SET title = '$title', content = '$content', category_id = $category_id 
            WHERE id = $post_id";

    if ($conn->query($sql) === TRUE) {
        echo "Post updated!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; color: #333; display: flex; justify-content: center; padding: 20px;">

<div style="background-color: #fff; padding: 20px; border-radius: 8px; width: 500px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; color: #333;">Edit Post</h1>
    
    <form method="POST" style="display: flex; flex-direction: column;">
        <label for="title" style="margin-bottom: 5px; color: #333;">Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="content" style="margin-bottom: 5px; color: #333;">Content</label>
        <textarea name="content" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($post['content']); ?></textarea>
        
        <label for="category" style="margin-bottom: 5px; color: #333;">Category</label>
        <select name="category" required style="padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            $categories = $conn->query("SELECT * FROM categories");
            while ($category = $categories->fetch_assoc()) {
                $selected = $category['id'] == $post['category_id'] ? 'selected' : '';
                echo "<option value='{$category['id']}' $selected>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select>
        
        <button type="submit" style="padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Update Post</button>
    </form>
</div>

</body>
</html>
