<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Category added!";
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Add Category Form -->
<form method="POST">
    <input type="text" name="category_name" placeholder="Category Name" required>
    <button type="submit">Add Category</button>
</form>
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Category added!";
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Add Category Form -->
<form method="POST">
    <input type="text" name="category_name" placeholder="Category Name" required>
    <button type="submit">Add Category</button>
</form>
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Category added!";
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Add Category Form -->
<form method="POST">
    <input type="text" name="category_name" placeholder="Category Name" required>
    <button type="submit">Add Category</button>
</form>
