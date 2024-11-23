<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM restaurants WHERE id = :id");
    $stmt->execute(['id' => $delete_id]);
    header('Location: admin_portal.php');
    exit;
}

// Fetch Restaurants for Display
$restaurants = $pdo->query("SELECT * FROM restaurants")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="/css/main.css">
    <title>Admin Portal</title>
</head>
<body>
  <div class="login">
<?php include "header.php"; ?>
    <h2>Manage Restaurants</h2>
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Menu Link</th>
            <th>Cost Category</th>
            <th>Food Type</th>
            <th>Subcategory</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($restaurants as $restaurant): ?>
        <tr>
            <td><?= htmlspecialchars($restaurant['name']) ?></td>
            <td>
                <?php if ($restaurant['menu_link']): ?>
                    <a href="<?= htmlspecialchars($restaurant['menu_link']) ?>" target="_blank">View Menu</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($restaurant['cost_category']) ?></td>
            <td><?= htmlspecialchars($restaurant['food_type']) ?></td>
            <td><?= htmlspecialchars($restaurant['food_type_subcategory']) ?></td>
            <td>
                <a href="edit_restaurant.php?id=<?= $restaurant['id'] ?>">Edit</a>
                |
                <a href="?delete_id=<?= $restaurant['id'] ?>" onclick="return confirm('Are you sure you want to delete this restaurant?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
