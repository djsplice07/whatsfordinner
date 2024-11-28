<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

// Handle Form Submission (Adding a New Restaurant)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_GET['edit_id'])) {
    $name = $_POST['name'];
    $google_map_link = $_POST['google_map_link'];
//    $google_map_link = urlencode($_POST['google_map_link']); - tried to remove invalid characters, but affected the :// in URL
    $menu_link = $_POST['menu_link'];
    $cost_category = $_POST['cost_category'];
    $food_type = $_POST['food_type'];
    $food_type_subcategory = $_POST['food_type_subcategory'];

    $stmt = $pdo->prepare("
        INSERT INTO restaurants (name, google_map_link, menu_link, cost_category, food_type, food_type_subcategory)
        VALUES (:name, :google_map_link, :menu_link, :cost_category, :food_type, :food_type_subcategory)
    ");
    $stmt->execute([
        'name' => $name,
        'google_map_link' => $google_map_link,
        'menu_link' => $menu_link,
        'cost_category' => $cost_category,
        'food_type' => $food_type,
        'food_type_subcategory' => $food_type_subcategory,
    ]);
    $success = "Restaurant added successfully!";
}

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
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    
    <h2>Add New Restaurant</h2>
    <form method="POST">
        <label for="cost_category">Cost Category:</label>
        <select class="minimal" name="cost_category" id="cost_category" required>
            <option value="cheap">Cheap</option>
            <option value="moderate">Moderate</option>
            <option value="expensive">Expensive</option>
        </select><br>
		<br>
		
		<!--<label for="name">Restaurant Name:</label>
        <input type="text" name="name" id="name" required><br> -->
		<input type="text" name="name" placeholder="Restaurant Name" id="name" required /><br>
        
        <!--<label for="google_map_link">Google Map Link:</label>
        <input type="url" name="google_map_link" id="google_map_link" required><br> -->
		<input type="url" name="google_map_link" placeholder="Google Map Link" id="google_map_link" /><br>
        
        <!--<label for="menu_link">Menu Link (optional):</label>
        <input type="url" name="menu_link" id="menu_link"><br> -->
		<input type="url" name="menu_link" placeholder="Menu Link (optional)" id="menu_link"/><br>
        
        <!--<label for="food_type">Food Type:</label>
        <input type="text" name="food_type" id="food_type" required><br> -->
        <input type="text" name="food_type" placeholder="Food Type" id="food_type" required /><br>
		
        <!--<label for="food_type_subcategory">Food Type Subcategory (optional):</label>
        <input type="text" name="food_type_subcategory" id="food_type_subcategory"><br> -->
		<input type="text" name="food_type_subcategory" placeholder="Keywords (comma seperated)" id="food_type_subcategory" /><br>
        
        <button class="btn btn-primary btn-block btn-large" type="submit">Add Restaurant</button>
    </form>
</div>
</body>
</html>
