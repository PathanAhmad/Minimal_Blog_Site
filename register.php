<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; color: #333; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;">

<div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px;">
    <h2 style="text-align: center; color: #333;">Register</h2>

    <!-- Display error message if registration fails -->
    <?php if (isset($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" style="display: flex; flex-direction: column;">
        <input type="text" name="username" placeholder="Username" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <input type="email" name="email" placeholder="Email" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <input type="password" name="password" placeholder="Password" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <button type="submit" style="padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Register</button>
    </form>

    <p style="text-align: center; margin-top: 10px; color: #666;">
        Already have an account? <a href="login.php" style="color: #333; text-decoration: none;">Login here</a>
    </p>
    <p style="text-align: center; color: #666;">
        Or <a href="index.php" style="color: #333; text-decoration: none;">Continue as Guest</a>
    </p>
</div>

</body>
</html>
