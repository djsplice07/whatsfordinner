<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = :id");
$stmt->execute(['id' => $id]);
$restaurant = $stmt->fetch();

if (!$restaurant) {
    echo "Restaurant not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $google_map_link = $_POST['google_map_link'];
    $menu_link = $_POST['menu_link'];
    $cost_category = $_POST['cost_category'];
    $food_type = $_POST['food_type'];
    $food_type_subcategory = $_POST['food_type_subcategory'];

    $stmt = $pdo->prepare("
        UPDATE restaurants
        SET name = :name, google_map_link = :google_map_link, menu_link = :menu_link,
            cost_category = :cost_category, food_type = :food_type, food_type_subcategory = :food_type_subcategory
        WHERE id = :id
    ");
    $stmt->execute([
        'name' => $name,
        'google_map_link' => $google_map_link,
        'menu_link' => $menu_link,
        'cost_category' => $cost_category,
        'food_type' => $food_type,
        'food_type_subcategory' => $food_type_subcategory,
        'id' => $id,
    ]);

    header('Location: manage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="/css/main.css">
    <title>Restaurant Picker - Edit Restaurant</title>
</head>
<body>
  <div class="login">
<?php include "header.php"; ?>
    <h2>Edit Restaurant</h2>
    <form method="POST">
		<label for="cost_category">Price:&nbsp;</label>
        <select class="minimal" name="cost_category" id="cost_category" required>
            <option value="cheap" <?= $restaurant['cost_category'] === 'cheap' ? 'selected' : '' ?>>Cheap</option>
            <option value="moderate" <?= $restaurant['cost_category'] === 'moderate' ? 'selected' : '' ?>>Moderate</option>
            <option value="expensive" <?= $restaurant['cost_category'] === 'expensive' ? 'selected' : '' ?>>Expensive</option>
        </select><br>
		<br />
		
        <label for="name">Restaurant Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($restaurant['name']) ?>" required><br>
        
        <label for="google_map_link">Google Map Link:</label>
        <input type="url" name="google_map_link" id="google_map_link" value="<?= htmlspecialchars($restaurant['google_map_link']) ?>" required><br>
        
        <label for="menu_link">Menu Link (optional):</label>
        <input type="url" name="menu_link" id="menu_link" value="<?= htmlspecialchars($restaurant['menu_link']) ?>"><br>
        
        <label for="food_type">Food Type:</label>
        <input type="text" name="food_type" id="food_type" value="<?= htmlspecialchars($restaurant['food_type']) ?>" required><br>
        
        <label for="food_type_subcategory">Food Type Subcategory (optional):</label>
        <input type="text" name="food_type_subcategory" id="food_type_subcategory" value="<?= htmlspecialchars($restaurant['food_type_subcategory']) ?>"><br>
        
        <button class="btn btn-primary btn-block btn-large" type="submit">Update Restaurant</button>
    </form>
</div>
</body>
</html>
