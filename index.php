<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cost_category = $_POST['cost_category'] ?? '';
    $food_type = $_POST['food_type'] ?? '';
    $food_type_subcategory = $_POST['food_type_subcategory'] ?? '';

    // Start building the query
    $query = "SELECT * FROM restaurants WHERE 1=1";  // Always true condition to avoid extra WHERE clauses
    $params = [];

    // Only apply the cost category filter if it's not 'any'
    if ($cost_category && $cost_category !== 'any') {
        $query .= " AND cost_category = :cost_category";
        $params['cost_category'] = $cost_category;
    }

    // Only apply the food type filter if it's not 'any'
    if ($food_type && $food_type !== 'any') {
        $query .= " AND food_type = :food_type";
        $params['food_type'] = $food_type;
    }

    // Apply the food type subcategory filter if provided
    if (!empty($food_type_subcategory)) {
        // Split the subcategory into keywords by commas and trim any spaces
        $keywords = array_map('trim', explode(',', $food_type_subcategory));

        // Create an array of LIKE conditions for each keyword
        $subquery = [];
        foreach ($keywords as $index => $keyword) {
            // Use LIKE to match the subcategory
            $subquery[] = "food_type_subcategory LIKE :food_type_subcategory_{$index}";
            $params["food_type_subcategory_{$index}"] = "%{$keyword}%";
        }

        // Join the subqueries with OR to match any of the keywords
        $query .= " AND (" . implode(' OR ', $subquery) . ")";
    }

    // Random selection with a limit of 1 result
    $query .= " ORDER BY RAND() LIMIT 1";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $restaurant = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="/css/main.css">
    <title>Restaurant Picker</title>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const subcategoryInput = document.getElementById("food_type_subcategory");

            subcategoryInput.addEventListener("input", () => {
                const query = subcategoryInput.value;
                if (query.length < 2) return;

                fetch(`subcategory_suggestions.php?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        const datalist = document.getElementById("subcategorySuggestions");
                        datalist.innerHTML = "";
                        data.forEach(keyword => {
                            const option = document.createElement("option");
                            option.value = keyword;
                            datalist.appendChild(option);
                        });
                    });
            });
        });
    </script>
</head>
<body>
  <div class="login">
<?php include "header.php"; ?>
    <form method="post">
        <label for="cost_category">Price:&nbsp;</label>
      <select class="minimal" name="cost_category" id="cost_category" required>
            <option value="any">Any</option>
            <option value="cheap">Cheap</option>
            <option value="moderate">Moderate</option>
            <option value="expensive">Expensive</option>
      </select><br>
	  <br />
        <label for="food_type">Cuisine:&nbsp;</label>
      <select class="minimal" name="food_type" id="food_type" required>
            <option value="any">Any</option>
            <?php
            $types = $pdo->query("SELECT DISTINCT food_type FROM restaurants")->fetchAll();
            foreach ($types as $type) {
                echo "<option value=\"" . htmlspecialchars($type['food_type']) . "\">" . htmlspecialchars($type['food_type']) . "</option>";
            }
            ?>
        </select><br>
		<br />
		<input type="text" name="food_type_subcategory" placeholder="Keyword(s)" id="food_type_subcategory" list="subcategorySuggestions" />
        <datalist id="subcategorySuggestions"></datalist><br>

        <button type="submit" class="btn btn-primary btn-block btn-large">Find Restaurant</button>
    </form>

    <?php if (!empty($restaurant)): ?>
        <h3>Selected Restaurant:</h3>
    <p><h2><b><?= htmlspecialchars($restaurant['name']) ?>&nbsp;<img src="images/arrow_sm.png"></img></b></h2></p>
        <p><a href="<?= htmlspecialchars($restaurant['menu_link']) ?>" target="_blank">View Menu</a></p>
<?php
// Extract the base URL and the query parameters
$baseUrl = "https://www.google.com/maps/embed";
$queryString = parse_url($restaurant['google_map_link'], PHP_URL_QUERY);

// Encode the query string only
$encodedQuery = urlencode($queryString);

// Rebuild the final URL
$finalMapUrl = $baseUrl . "?pb=" . $encodedQuery;
?>
<p align="center">
<iframe
    src="<?= htmlspecialchars($restaurant['google_map_link']) ?>" 
    width="600" 
    height="450" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy">
</iframe>
<br />
<br />
</p>
    <?php else: ?>
        <p>No results found based on your criteria.</p>
    <?php endif; ?>
<br />
  </div>
</body>
</html>
