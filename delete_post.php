<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate and sanitize the input
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = (int) $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        // Optionally, you could store a success message in the session to display after redirection
        header("Location: dashboard.php");
        exit();
    } else {
        // Log error or handle it accordingly
        echo "Error: " . htmlspecialchars($conn->error);
    }

    $stmt->close();
} else {
    echo "Invalid post ID.";
}

$conn->close();
?>
