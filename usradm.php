<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $username = $_POST['username'];
    $password = $_POST['password_hash'];

    // Hash the password for secure storage
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (:username, :password_hash)");
        $stmt->execute(['username' => $username, 'password_hash' => $password_hash]);
        $message = "User added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle deleting a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $user_id = $_POST['user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM admin_users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $message = "User deleted successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle updating a user's password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];

    // Hash the new password
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = :password_hash WHERE id = :id");
        $stmt->execute(['password_hash' => $password_hash, 'id' => $user_id]);
        $message = "Password updated successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch all users
$users = $pdo->query("SELECT id, username FROM admin_users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Management</title>
</head>
<body>
 <div class="login">
 	<?php include "header.php"; ?>
    <h2>Admin - User Management</h2>
    <?php if (isset($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h3>Add a New User</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add_user">
        <!-- <label>Username: <input type="text" name="username" required></label><br> -->
	  <input type="text" name="username" placeholder="Username" required /><br>
        <!-- <label>Password: <input type="password" name="password" required></label><br> -->
		<input type="password" name="password" placeholder="Password" required /><br>
        <button class="btn btn-primary btn-block btn-large" type="submit">Add User</button>
    </form>

    <h3>Existing Users</h3>
    <table width="800" border="1">
        <tr>
            <th width="17">ID</th>
            <th width="82">Username</th>
            <th width="66">Actions</th>
			<th width="66">Password</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td>
                <!-- Delete User -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <button class="btn btn-primary btn-block btn-large" type="submit" style="color:red;" onclick="return confirm('Are you sure you want to delete this restaurant?');">Delete</button>
                </form>
			</td>
			<td width="362">
                <!-- Update Password -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="update_password">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <!-- <label>New Password: <input type="password" name="new_password" required></label> -->
					<input type="password" name="new_password" placeholder="New Password" required /><br>
                    <button class="btn btn-primary btn-block btn-large" type="submit">Update Password</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
 </div>
</body>
</html>
