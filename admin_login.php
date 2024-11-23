<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        // Check if the password matches using bcrypt
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin_portal.php');
            exit;
        } 
        // Check if the password matches using SHA-256 (legacy support)
        elseif (hash('sha256', $password) === $user['password_hash']) {
            // Rehash the password with bcrypt for future logins
            $new_hash = password_hash($password, PASSWORD_BCRYPT);
            $update_stmt = $pdo->prepare("UPDATE admin_users SET password_hash = :new_hash WHERE id = :id");
            $update_stmt->execute(['new_hash' => $new_hash, 'id' => $user['id']]);

            $_SESSION['admin_logged_in'] = true;
            header('Location: admin_portal.php');
            exit;
        }
    }

    // If neither bcrypt nor SHA-256 matched
    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/main.css">
    <title>Restaurant Picker - Admin Login</title>
</head>
<body>
  <div class="login">
    <?php include "header.php"; ?>
    <h2>Admin Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <!--<label for="text">Username:</label>
        <input type="text" name="username" id="username" required> -->
		<input type="text" name="username" id="username" placeholder="Username" required /><br>
        <br>
        <!--<label for="password">Password:</label>
        <input type="password" name="password" id="password" required> -->
		<input type="password" name="password" id="password" placeholder="Password" required /><br>
        <br>
        <button class="btn btn-primary btn-block btn-large" type="submit">Login</button>
    </form>
</body>
</html>
